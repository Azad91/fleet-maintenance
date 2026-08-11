<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Complaint;
use App\Models\ComplaintType;  // YENİ
use App\Models\Warehouse;      // YENİ
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComplaintsImport;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('bus')->orderBy('id', 'desc')->get();
        return view('complaints.index', compact('complaints'));
    }

    public function search(Request $request)
    {
        $dqn = $request->dqn;
        $xett_no = $request->xett_no;
        $yer = $request->yer;
        $shikayet = $request->shikayet;

        $complaints = Complaint::with('bus')
            ->when($dqn, function ($query, $dqn) {
                return $query->whereHas('bus', function ($q) use ($dqn) {
                    $q->where('dqn', 'ILIKE', "%{$dqn}%");
                });
            })
            ->when($xett_no, function ($query, $xett_no) {
                return $query->whereHas('bus', function ($q) use ($xett_no) {
                    $q->where('xett_no', 'ILIKE', "%{$xett_no}%");
                });
            })
            ->when($yer, function ($query, $yer) {
                return $query->where('yer', $yer);
            })
            ->when($shikayet, function ($query, $shikayet) {
                return $query->where('shikayet', 'ILIKE', "%{$shikayet}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('complaints.partials.table', compact('complaints', 'dqn', 'xett_no', 'yer', 'shikayet'));
    }

    public function create()
    {
        $buses = Bus::orderBy('xett_no')->get();
        $complaintTypes = ComplaintType::orderBy('name')->get();
        return view('complaints.create', compact('buses', 'complaintTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'yer' => 'nullable|string|in:yol,qaraj',
            'surucu_adi' => 'nullable|string|max:255',
            'shikayet' => 'nullable|array',
            'shikayet.*' => 'nullable|string|max:1000',
            'sikayet_tipi' => 'nullable|in:qezali,texniki_xidmet,nasazliq',
            'bildirilme_tarix' => 'nullable|date',
            'bildirilme_saat' => 'nullable|date_format:H:i',
            'is_baslama_tarix' => 'nullable|date',
            'is_baslama_saat' => 'nullable|date_format:H:i',
            'is_bitme_tarix' => 'nullable|date',
            'is_bitme_saat' => 'nullable|date_format:H:i',
            'status' => 'required|in:gözləmədə,işdə,həll olundu',
            'km' => 'nullable|integer|min:0',
            'qeyd' => 'nullable|string',
            'kim_is_gorub' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        // Şikayət array - ni string - ə çevir
        if ($request->has('shikayet') && is_array($request->shikayet)) {
            $data['shikayet'] = implode("\n", array_filter($request->shikayet));
        }

        // Detalları JSON olaraq saxla
        if ($request->has('detallar') && is_array($request->detallar)) {
            $data['detallar'] = json_encode($request->detallar, JSON_UNESCAPED_UNICODE);

            // Hər detal üçün anbar miqdarını yenilə
            foreach ($request->detallar as $detal) {
                if (!empty($detal['kodu']) && !empty($detal['islenen_miqdar']) && $detal['islenen_miqdar'] > 0) {
                    $warehouse = \App\Models\Warehouse::where('kod', $detal['kodu'])->first();
                    if ($warehouse) {
                        $warehouse->miqdar = $warehouse->miqdar - $detal['islenen_miqdar'];
                        $warehouse->save();
                    }
                }
            }
        }

        Complaint::create($data);

        return redirect()->route('complaints.index')->with('success', 'Şikayət uğurla əlavə edildi!');
    }

    public function show($id)
    {
        $complaint = Complaint::with('bus')->findOrFail($id);

        // Detalları array - a çevir
        if ($complaint->detallar) {
            $complaint->detallar = is_array($complaint->detallar) ? $complaint->detallar : json_decode($complaint->detallar, true);
        }

        return view('complaints.show', compact('complaint'));
    }

    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        $buses = Bus::orderBy('xett_no')->get();
        $complaintTypes = ComplaintType::orderBy('name')->get();

        // Detalları array - a çevir
        if ($complaint->detallar) {
            $complaint->detallar = is_array($complaint->detallar) ? $complaint->detallar : json_decode($complaint->detallar, true);
        }

        return view('complaints.edit', compact('complaint', 'buses', 'complaintTypes'));
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'yer' => 'nullable|string|in:yol,qaraj',
            'surucu_adi' => 'nullable|string|max:255',
            'shikayet' => 'nullable|array',
            'shikayet.*' => 'nullable|string|max:1000',
            'sikayet_tipi' => 'nullable|in:qezali,texniki_xidmet,nasazliq',
            'bildirilme_tarix' => 'nullable|date',
            'bildirilme_saat' => 'nullable|date_format:H:i',
            'is_baslama_tarix' => 'nullable|date',
            'is_baslama_saat' => 'nullable|date_format:H:i',
            'is_bitme_tarix' => 'nullable|date',
            'is_bitme_saat' => 'nullable|date_format:H:i',
            'status' => 'required|in:gözləmədə,işdə,həll olundu',
            'km' => 'nullable|integer|min:0',
            'qeyd' => 'nullable|string',
            'kim_is_gorub' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        // Şikayət array - ni string - ə çevir
        if ($request->has('shikayet') && is_array($request->shikayet)) {
            $data['shikayet'] = implode("\n", array_filter($request->shikayet));
        }

        // Detalları JSON olaraq saxla
        if ($request->has('detallar') && is_array($request->detallar)) {
            $detallar = array_filter($request->detallar, function($detal) {
                return !empty($detal['kodu']) || !empty($detal['islenen_miqdar']);
            });
            $data['detallar'] = json_encode($detallar, JSON_UNESCAPED_UNICODE);

            // Hər detal üçün anbar miqdarını yenilə
            foreach ($detallar as $detal) {
                if (!empty($detal['kodu']) && !empty($detal['islenen_miqdar']) && $detal['islenen_miqdar'] > 0) {
                    $warehouse = \App\Models\Warehouse::where('kod', $detal['kodu'])->first();
                    if ($warehouse) {
                        $warehouse->miqdar = $warehouse->miqdar - $detal['islenen_miqdar'];
                        $warehouse->save();
                    }
                }
            }
        } else {
            $data['detallar'] = null;
        }

        $complaint->update($data);

        return redirect()->route('complaints.index')->with('success', 'Şikayət uğurla yeniləndi!');
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Şikayət uğurla silindi!');
    }

    // =============== IMPORT ===============
    public function importForm()
    {
        return view('complaints.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ComplaintsImport, $request->file('file'));
            return redirect()->route('complaints.index')->with('success', 'Şikayətlər uğurla idxal edildi!');
        } catch (\Exception $e) {
            return redirect()->route('complaints.index')->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }
}
