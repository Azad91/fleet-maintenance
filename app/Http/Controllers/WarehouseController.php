<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WarehouseImport;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $warehouses = Warehouse::when($search, function ($query, $search) {
            return $query->where('kod', 'ILIKE', "%{$search}%")
                        ->orWhere('ad', 'ILIKE', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->get();

        return view('warehouses.index', compact('warehouses', 'search'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $warehouses = Warehouse::when($search, function ($query, $search) {
            return $query->where('kod', 'ILIKE', "%{$search}%")
                        ->orWhere('ad', 'ILIKE', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->get();

        return view('warehouses.partials.table', compact('warehouses', 'search'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kod' => 'required|unique:warehouses,kod',
            'ad' => 'required|string|max:255',
            'miqdar' => 'required|integer|min:0',
            'olcu_vahidi' => 'nullable|string|max:50',
            'qiymet' => 'nullable|numeric|min:0',
        ]);

        Warehouse::create($request->all());

        return redirect()->route('warehouses.index')->with('success', 'Anbar məlumatı uğurla əlavə edildi!');
    }

    public function show($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouses.show', compact('warehouse'));
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        $request->validate([
            'kod' => 'required|unique:warehouses,kod,' . $id,
            'ad' => 'required|string|max:255',
            'miqdar' => 'required|integer|min:0',
            'olcu_vahidi' => 'nullable|string|max:50',
            'qiymet' => 'nullable|numeric|min:0',
        ]);

        $warehouse->update($request->all());

        return redirect()->route('warehouses.index')->with('success', 'Anbar məlumatı uğurla yeniləndi!');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect()->route('warehouses.index')->with('success', 'Anbar məlumatı uğurla silindi!');
    }

    // =============== IMPORT ===============

    public function importForm()
    {
        return view('warehouses.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new WarehouseImport, $request->file('file'));
            return redirect()->route('warehouses.index')->with('success', 'Anbar məlumatları uğurla idxal edildi!');
        } catch (\Exception $e) {
            return redirect()->route('warehouses.index')->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }
}
