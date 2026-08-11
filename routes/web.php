<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\DailyKmController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ==================== DASHBOARD ====================
Route::get('/dashboard', function () {
    $totalBuses = App\Models\Bus::count();
    $totalComplaints = App\Models\Complaint::count();
    $totalWarehouses = App\Models\Warehouse::count();

    $recentComplaints = App\Models\Complaint::with('bus')
        ->orderBy('id', 'desc')
        ->limit(5)
        ->get();

    $recentWarehouses = App\Models\Warehouse::orderBy('id', 'desc')->limit(5)->get();

    $recentBuses = App\Models\Bus::orderBy('id', 'desc')->limit(5)->get();

    $lowStockItems = App\Models\Warehouse::whereColumn('miqdar', '<=', 'minimum_miqdar')->get();

    return view('dashboard', compact(
        'totalBuses',
        'totalComplaints',
        'totalWarehouses',
        'recentComplaints',
        'recentWarehouses',
        'recentBuses',
        'lowStockItems'
    ));
})->name('dashboard');

// ==================== BUS ROUTES ====================
Route::get('buses/search', [BusController::class, 'search'])->name('buses.search');
Route::get('buses/import', [BusController::class, 'importForm'])->name('buses.import');
Route::post('buses/import', [BusController::class, 'import'])->name('buses.import.store');

Route::get('buses', [BusController::class, 'index'])->name('buses.index');
Route::get('buses/{bus}', [BusController::class, 'show'])->name('buses.show');

// ==================== COMPLAINT ROUTES ====================
Route::get('complaints/search', [ComplaintController::class, 'search'])->name('complaints.search');
Route::get('complaints/import', [ComplaintController::class, 'importForm'])->name('complaints.import');
Route::post('complaints/import', [ComplaintController::class, 'import'])->name('complaints.import.store');
Route::resource('complaints', ComplaintController::class);

// ==================== COMPLAINT TYPES ROUTES ====================
Route::get('complaint-types/import', [ComplaintTypeController::class, 'importForm'])->name('complaint-types.import');
Route::post('complaint-types/import', [ComplaintTypeController::class, 'import'])->name('complaint-types.import.store');
Route::resource('complaint-types', ComplaintTypeController::class);

// ==================== WAREHOUSE ROUTES ====================
Route::get('warehouses/search', [WarehouseController::class, 'search'])->name('warehouses.search');
Route::get('warehouses/import', [WarehouseController::class, 'importForm'])->name('warehouses.import');
Route::post('warehouses/import', [WarehouseController::class, 'import'])->name('warehouses.import.store');
Route::resource('warehouses', WarehouseController::class);

// ==================== DAILY KM ROUTES ====================
Route::get('daily-km/import', [DailyKmController::class, 'importForm'])->name('daily-km.import');
Route::post('daily-km/import', [DailyKmController::class, 'import'])->name('daily-km.import.store');
Route::resource('daily-km', DailyKmController::class);

// ==================== API ROUTES ====================
Route::get('get-dqn-by-xett/{xett_no}', function ($xett_no) {
    $bus = App\Models\Bus::where('xett_no', $xett_no)->first();
    return response()->json(['dqn' => $bus ? $bus->dqn : null]);
})->name('get.dqn.by.xett');

Route::get('get-bus-id-by-xett/{xett_no}', function ($xett_no) {
    $bus = App\Models\Bus::where('xett_no', $xett_no)->first();
    return response()->json([
        'dqn' => $bus ? $bus->dqn : null,
        'bus_id' => $bus ? $bus->id : null
    ]);
})->name('get.bus.id.by.xett');

Route::get('get-detal-by-kod/{kod}', function ($kod) {
    $detal = App\Models\Warehouse::where('kod', $kod)->first();
    return response()->json([
        'detal_adi' => $detal ? $detal->ad : null,
        'depo_miqdari' => $detal ? $detal->miqdar : null,
        'qiymet' => $detal ? $detal->qiymet : null,
        'olcu_vahidi' => $detal ? $detal->olcu_vahidi : null,
    ]);
})->name('get.detal.by.kod');

Route::get('get-bus-km-by-id/{bus_id}', function ($bus_id) {
    $bus = App\Models\Bus::find($bus_id);
    return response()->json(['km' => $bus ? $bus->km : null]);
})->name('get.bus.km.by.id');
