<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\DailyKm;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DailyKmImport;

class DailyKmController extends Controller
{
    public function index()
    {
        $dailyKms = DailyKm::with('bus')->orderBy('tarix', 'desc')->get();
        return view('daily-km.index', compact('dailyKms'));
    }

    public function create()
    {
        $buses = Bus::orderBy('dqn')->get();
        return view('daily-km.create', compact('buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'tarix' => 'required|date',
            'km' => 'required|integer|min:0',
        ]);

        DailyKm::updateOrCreate(
            ['bus_id' => $request->bus_id, 'tarix' => $request->tarix],
            ['km' => $request->km]
        );

        return redirect()->route('daily-km.index')->with('success', 'Gündəlik KM uğurla əlavə edildi!');
    }

    public function show($id)
    {
        $dailyKm = DailyKm::with('bus')->findOrFail($id);
        return view('daily-km.show', compact('dailyKm'));
    }

    public function edit($id)
    {
        $dailyKm = DailyKm::with('bus')->findOrFail($id);
        $buses = Bus::orderBy('dqn')->get();
        return view('daily-km.edit', compact('dailyKm', 'buses'));
    }

    public function update(Request $request, $id)
    {
        $dailyKm = DailyKm::findOrFail($id);

        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'tarix' => 'required|date',
            'km' => 'required|integer|min:0',
        ]);

        $dailyKm->update($request->all());

        return redirect()->route('daily-km.index')->with('success', 'Gündəlik KM uğurla yeniləndi!');
    }

    public function destroy($id)
    {
        $dailyKm = DailyKm::findOrFail($id);
        $dailyKm->delete();

        return redirect()->route('daily-km.index')->with('success', 'Gündəlik KM uğurla silindi!');
    }

    // =============== IMPORT ===============
    public function importForm()
    {
        return view('daily-km.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new DailyKmImport, $request->file('file'));
            return redirect()->route('daily-km.index')->with('success', 'Gündəlik KM məlumatları uğurla idxal edildi!');
        } catch (\Exception $e) {
            return redirect()->route('daily-km.index')->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }
}
