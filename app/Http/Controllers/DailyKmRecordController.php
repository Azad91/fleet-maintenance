<?php

namespace App\Http\Controllers;

use App\Models\DailyKmRecord;
use App\Models\Bus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DailyKmRecordsImport;

class DailyKmRecordController extends Controller
{
public function index(Request $request)
{
    $search = $request->search;
    $query = DailyKmRecord::with('bus');

    if ($search) {
        $query->whereHas('bus', function($q) use ($search) {
            $q->where('dqn', 'ILIKE', "%{$search}%")
              ->orWhere('xett_no', 'ILIKE', "%{$search}%");
        })->orWhere('tarix', 'ILIKE', "%{$search}%");
    }

    // BURADA GET() ƏVƏZİNƏ PAGINATE() İSTİFADƏ EDİRİK
    // Hər səhifədə 100 qeyd göstər
    $records = $query->orderBy('tarix', 'desc')->paginate(100);

    return view('daily-km-records.index', compact('records', 'search'));
}

    public function create()
    {
        $buses = Bus::orderBy('dqn')->get();
        return view('daily-km-records.create', compact('buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'tarix'  => 'required|date',
            'km'     => 'required|integer|min:0',
        ]);

        DailyKmRecord::create($request->all());
        return redirect()->route('daily-km-records.index')->with('success', 'KM məlumatı uğurla əlavə edildi!');
    }

    public function show($id)
    {
        $record = DailyKmRecord::with('bus')->findOrFail($id);
        return view('daily-km-records.show', compact('record'));
    }

    public function edit($id)
    {
        $record = DailyKmRecord::findOrFail($id);
        $buses = Bus::orderBy('dqn')->get();
        return view('daily-km-records.edit', compact('record', 'buses'));
    }

    public function update(Request $request, $id)
    {
        $record = DailyKmRecord::findOrFail($id);
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'tarix'  => 'required|date',
            'km'     => 'required|integer|min:0',
        ]);
        $record->update($request->all());
        return redirect()->route('daily-km-records.index')->with('success', 'KM məlumatı yeniləndi!');
    }

    public function destroy($id)
    {
        $record = DailyKmRecord::findOrFail($id);
        $record->delete();
        return redirect()->route('daily-km-records.index')->with('success', 'KM məlumatı silindi!');
    }

    public function importForm()
    {
        set_time_limit(600); // 10 dəqiqə vaxt ver
        return view('daily-km-records.import');
    }

    public function import(Request $request)
    {
        // VAXT VƏ YADDAŞ LİMİTİNİ 30 DƏQİQƏYƏ ÇIXAR
        set_time_limit(1800);
        ini_set('memory_limit', '1024M');

        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new DailyKmRecordsImport, $request->file('file'));
            return redirect()->route('daily-km-records.index')->with('success', 'KM məlumatları uğurla idxal edildi!');
        } catch (\Exception $e) {
            return redirect()->route('daily-km-records.index')->with('error', 'Xəta: ' . $e->getMessage());
        }
    }
}
