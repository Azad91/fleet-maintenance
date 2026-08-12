<?php

namespace App\Http\Controllers;

use App\Models\MotorOilDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MotorOilImport;

class MotorOilController extends Controller
{
    public function index()
    {
        $details = MotorOilDetail::orderBy('km')->orderBy('detal_adi')->get();
        $grouped = $details->groupBy('km');
        return view('motor-oil.index', compact('grouped'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $details = MotorOilDetail::when($search, function ($query, $search) {
            return $query->where('km', $search);
        })
        ->orderBy('km')
        ->orderBy('detal_adi')
        ->get();

        $grouped = $details->groupBy('km');

        return view('motor-oil.partials.table', compact('grouped', 'search'));
    }

    public function importForm()
    {
        return view('motor-oil.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MotorOilImport, $request->file('file'));
            return redirect()->route('motor-oil.index')->with('success', 'Motor yağ detalları uğurla idxal edildi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xəta: ' . $e->getMessage());
        }
    }
}
