<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BusesImport;

class BusController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort ?? 'id'; // default: id
        $order = $request->order ?? 'asc'; // default: asc

        $buses = Bus::orderBy($sort, $order)->get();

        return view('buses.index', compact('buses', 'sort', 'order'));
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
        ->get();

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
