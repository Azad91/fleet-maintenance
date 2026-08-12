<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintStoreRequest;
use App\Http\Requests\ComplaintUpdateRequest;
use App\Models\Bus;
use App\Models\Complaint;
use App\Models\ComplaintType;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComplaintsImport;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('bus')
            ->orderBy('id', 'desc')
            ->paginate(config('settings.pagination', 15));
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
            ->paginate(config('settings.pagination', 15));

        return view('complaints.partials.table', compact('complaints', 'dqn', 'xett_no', 'yer', 'shikayet'));
    }

    public function create()
    {
        $buses = Bus::orderBy('xett_no')->get();
        $complaintTypes = ComplaintType::orderBy('name')->get();
        return view('complaints.create', compact('buses', 'complaintTypes'));
    }

    public function store(ComplaintStoreRequest $request)
    {
        $data = $request->validated();

        // Şikayət array - ni string - ə çevir
        if ($request->has('shikayet') && is_array($request->shikayet)) {
            $data['shikayet'] = implode("\n", array_filter($request->shikayet));
        }

        // Detalları JSON olaraq saxla
        if ($request->has('detallar') && is_array($request->detallar)) {
            $detallar = [];
            foreach ($request->detallar as $detal) {
                if (!empty($detal['kodu'])) {
                    $warehouse = Warehouse::where('kod', $detal['kodu'])->first();
                    $detallar[] = [
                        'shikayet_index' => $detal['shikayet_index'] ?? 0,
                        'kodu' => $detal['kodu'],
                        'adi' => $warehouse ? $warehouse->ad : null,
                        'depo_miqdari' => $warehouse ? $warehouse->miqdar : null,
                        'islenen_miqdar' => $detal['islenen_miqdar'] ?? 0,
                    ];

                    if ($warehouse && !empty($detal['islenen_miqdar']) && $detal['islenen_miqdar'] > 0) {
                        $warehouse->miqdar = $warehouse->miqdar - $detal['islenen_miqdar'];
                        $warehouse->save();
                    }
                }
            }
            $data['detallar'] = json_encode($detallar, JSON_UNESCAPED_UNICODE);
        } else {
            $data['detallar'] = null;
        }

        Complaint::create($data);
        return redirect()->route('complaints.index')->with('success', 'Şikayət uğurla əlavə edildi!');
    }

    public function show($id)
    {
        $complaint = Complaint::with('bus')->findOrFail($id);
        return view('complaints.show', compact('complaint'));
    }

    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        $buses = Bus::orderBy('xett_no')->get();
        $complaintTypes = ComplaintType::orderBy('name')->get();
        return view('complaints.edit', compact('complaint', 'buses', 'complaintTypes'));
    }

    public function update(ComplaintUpdateRequest $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $data = $request->validated();

        // Şikayət array - ni string - ə çevir
        if ($request->has('shikayet') && is_array($request->shikayet)) {
            $data['shikayet'] = implode("\n", array_filter($request->shikayet));
        }

        // Köhnə detalları yadda saxla (anbar əməliyyatı üçün)
        $oldDetallar = is_array($complaint->detallar) ? $complaint->detallar : json_decode($complaint->detallar, true);

        // Köhnə detalları geri qaytar (anbara)
        if ($oldDetallar) {
            foreach ($oldDetallar as $detal) {
                if (!empty($detal['kodu']) && !empty($detal['islenen_miqdar']) && $detal['islenen_miqdar'] > 0) {
                    $warehouse = Warehouse::where('kod', $detal['kodu'])->first();
                    if ($warehouse) {
                        $warehouse->miqdar = $warehouse->miqdar + $detal['islenen_miqdar'];
                        $warehouse->save();
                    }
                }
            }
        }

        // Yeni detalları yığ və anbardan çıxar
        if ($request->has('detallar') && is_array($request->detallar)) {
            $detallar = [];
            foreach ($request->detallar as $detal) {
                if (!empty($detal['kodu'])) {
                    $warehouse = Warehouse::where('kod', $detal['kodu'])->first();
                    $detallar[] = [
                        'shikayet_index' => $detal['shikayet_index'] ?? 0,
                        'kodu' => $detal['kodu'],
                        'adi' => $warehouse ? $warehouse->ad : null,
                        'depo_miqdari' => $warehouse ? $warehouse->miqdar : null,
                        'islenen_miqdar' => $detal['islenen_miqdar'] ?? 0,
                    ];

                    if ($warehouse && !empty($detal['islenen_miqdar']) && $detal['islenen_miqdar'] > 0) {
                        $warehouse->miqdar = $warehouse->miqdar - $detal['islenen_miqdar'];
                        $warehouse->save();
                    }
                }
            }
            $data['detallar'] = json_encode($detallar, JSON_UNESCAPED_UNICODE);
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
