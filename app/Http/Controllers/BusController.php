<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusStoreRequest;
use App\Http\Requests\BusUpdateRequest;
use App\Models\Bus;
use App\Models\DailyKm;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BusesImport;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::orderBy('id')->paginate(config('settings.pagination', 15));
        $dailyKms = DailyKm::with('bus')->orderBy('tarix', 'desc')->get(); // YENİ
        return view('buses.index', compact('buses', 'dailyKms')); // compact - a əlavə et
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';

        $buses = Bus::when($search, function ($query, $search) {
            return $query->where('dqn', 'ILIKE', "%{$search}%")
                        ->orWhere('xett_no', 'ILIKE', "%{$search}%")
                        ->orWhere('km', 'ILIKE', "%{$search}%");
        })
        ->orderBy($sort, $order)
        ->paginate(config('settings.pagination', 15));

        return view('buses.partials.table', compact('buses', 'search'));
    }

    public function show($id)
    {
        $bus = Bus::findOrFail($id);
        if ($bus->detallar) {
            $bus->detallar = is_array($bus->detallar) ? $bus->detallar : json_decode($bus->detallar, true);
        }
        return view('buses.show', compact('bus'));
    }

    public function create()
    {
        return view('buses.create');
    }

    public function store(BusStoreRequest $request)
    {
        $data = $request->validated();
        $data['tarix'] = now()->format('Y-m-d');  // <--- BUNU ƏLAVƏ ET
        Bus::create($data);
        return redirect()->route('buses.index')->with('success', 'Avtobus uğurla əlavə edildi!');
    }

    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        if ($bus->detallar) {
            $bus->detallar = is_array($bus->detallar) ? $bus->detallar : json_decode($bus->detallar, true);
        }
        return view('buses.edit', compact('bus'));
    }

    public function update(BusUpdateRequest $request, $id)
    {
        $bus = Bus::findOrFail($id);
        $data = $request->validated();
        $data['tarix'] = now()->format('Y-m-d');  // <--- BUNU ƏLAVƏ ET
        $bus->update($data);
        return redirect()->route('buses.index')->with('success', 'Avtobus uğurla yeniləndi!');
    }

    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);
        $bus->delete();
        return redirect()->route('buses.index')->with('success', 'Avtobus uğurla silindi!');
    }

    // =============== IMPORT ===============
    public function importForm()
    {
        return view('buses.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new BusesImport, $request->file('file'));
            return redirect()->route('buses.index')->with('success', 'Avtobuslar uğurla idxal edildi!');
        } catch (\Exception $e) {
            return redirect()->route('buses.index')->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }
}
