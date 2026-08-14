<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\DailyKmController;
use App\Http\Controllers\MotorOilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BusDailyStatusController;
use App\Http\Controllers\DailyKmRecordController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $totalBuses = App\Models\Bus::count();
        $totalComplaints = App\Models\Complaint::count();
        $totalWarehouses = App\Models\Warehouse::count();

        $recentComplaints = App\Models\Complaint::with('bus')->orderBy('id', 'desc')->limit(5)->get();
        $recentBuses = App\Models\Bus::orderBy('id', 'desc')->limit(5)->get();
        $lowStockItems = App\Models\Warehouse::whereColumn('miqdar', '<=', 'minimum_miqdar')->get();

        return view('dashboard', compact(
            'totalBuses', 'totalComplaints', 'totalWarehouses',
            'recentComplaints', 'recentBuses', 'lowStockItems'
        ));
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== BUS ROUTES ====================
    Route::prefix('buses')->name('buses.')->group(function () {

        // Qrup 1: Yalnız Admin üçün CRUD və Import
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/import', [BusController::class, 'importForm'])->name('import');
            Route::post('/import', [BusController::class, 'import'])->name('import.store');
            Route::get('/create', [BusController::class, 'create'])->name('create');
            Route::post('/', [BusController::class, 'store'])->name('store');
            Route::get('/{bus}/edit', [BusController::class, 'edit'])->name('edit');
            Route::put('/{bus}', [BusController::class, 'update'])->name('update');
            Route::delete('/{bus}', [BusController::class, 'destroy'])->name('destroy');
        });

        // Qrup 2: Admin, Bus, Directorate üçün baxış
        Route::middleware(['role:admin,bus,directorate'])->group(function () {
            Route::get('/', [BusController::class, 'index'])->name('index');
            Route::get('/search', [BusController::class, 'search'])->name('search');
            Route::get('/{bus}', [BusController::class, 'show'])->name('show');
        });
    });

    // ==================== COMPLAINT ROUTES ====================
    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::middleware(['role:admin,complaint'])->group(function () {
            Route::get('/import', [ComplaintController::class, 'importForm'])->name('import');
            Route::post('/import', [ComplaintController::class, 'import'])->name('import.store');
            Route::post('/', [ComplaintController::class, 'store'])->name('store');
            Route::get('/{complaint}/edit', [ComplaintController::class, 'edit'])->name('edit');
            Route::put('/{complaint}', [ComplaintController::class, 'update'])->name('update');
            Route::delete('/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');
        });

        Route::middleware(['role:admin,complaint,directorate'])->group(function () {
            Route::get('/', [ComplaintController::class, 'index'])->name('index');
            Route::get('/search', [ComplaintController::class, 'search'])->name('search');
            Route::get('/create', [ComplaintController::class, 'create'])->name('create');
            Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('show');
        });
    });

    // ==================== COMPLAINT TYPES ====================
    Route::prefix('complaint-types')->name('complaint-types.')->middleware(['role:admin'])->group(function () {
        Route::get('/import', [ComplaintTypeController::class, 'importForm'])->name('import');
        Route::post('/import', [ComplaintTypeController::class, 'import'])->name('import.store');
        Route::resource('/', ComplaintTypeController::class)->parameters(['' => 'complaint_type']);
    });

    // ==================== WAREHOUSE ROUTES ====================
    Route::prefix('warehouses')->name('warehouses.')->group(function () {
        Route::middleware(['role:admin,warehouse'])->group(function () {
            Route::get('/import', [WarehouseController::class, 'importForm'])->name('import');
            Route::post('/import', [WarehouseController::class, 'import'])->name('import.store');
            Route::get('/create', [WarehouseController::class, 'create'])->name('create');
            Route::post('/', [WarehouseController::class, 'store'])->name('store');
            Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit');
            Route::put('/{warehouse}', [WarehouseController::class, 'update'])->name('update');
            Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
        });

        Route::middleware(['role:admin,warehouse,directorate'])->group(function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('index');
            Route::get('/search', [WarehouseController::class, 'search'])->name('search');
            Route::get('/{warehouse}', [WarehouseController::class, 'show'])->name('show');
        });
    });

    // ==================== DAILY KM ROUTES ====================
    Route::prefix('daily-km')->name('daily-km.')->middleware(['role:admin'])->group(function () {
        Route::get('/import', [DailyKmController::class, 'importForm'])->name('import');
        Route::post('/import', [DailyKmController::class, 'import'])->name('import.store');
        Route::get('/create', [DailyKmController::class, 'create'])->name('create');
        Route::post('/', [DailyKmController::class, 'store'])->name('store');
        Route::get('/', [DailyKmController::class, 'index'])->name('index');
        Route::get('/{daily_km}/edit', [DailyKmController::class, 'edit'])->name('edit');
        Route::put('/{daily_km}', [DailyKmController::class, 'update'])->name('update');
        Route::delete('/{daily_km}', [DailyKmController::class, 'destroy'])->name('destroy');
    });

    // ==================== MOTOR OIL ROUTES ====================
    Route::prefix('motor-oil')->name('motor-oil.')->middleware(['role:admin'])->group(function () {
        Route::get('/', [MotorOilController::class, 'index'])->name('index');
        Route::get('/search', [MotorOilController::class, 'search'])->name('search');
        Route::get('/import', [MotorOilController::class, 'importForm'])->name('import');
        Route::post('/import', [MotorOilController::class, 'import'])->name('import.store');
    });

    // ==================== EMPLOYEE ROUTES ====================
    Route::prefix('employees')->name('employees.')->middleware(['role:admin'])->group(function () {
        Route::get('/import', [EmployeeController::class, 'importForm'])->name('import');
        Route::post('/import', [EmployeeController::class, 'import'])->name('import.store');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
    });

    // ==================== BUS DAILY STATUS ROUTES (YENİ) ====================
    Route::prefix('bus-daily-statuses')->name('bus-daily-statuses.')->middleware(['role:admin'])->group(function () {
        Route::get('/import', [BusDailyStatusController::class, 'importForm'])->name('import');
        Route::post('/import', [BusDailyStatusController::class, 'import'])->name('import.store');
        Route::get('/create', [BusDailyStatusController::class, 'create'])->name('create');
        Route::post('/', [BusDailyStatusController::class, 'store'])->name('store');
        Route::get('/', [BusDailyStatusController::class, 'index'])->name('index');
        Route::get('/{bus_daily_status}', [BusDailyStatusController::class, 'show'])->name('show');
        Route::get('/{bus_daily_status}/edit', [BusDailyStatusController::class, 'edit'])->name('edit');
        Route::put('/{bus_daily_status}', [BusDailyStatusController::class, 'update'])->name('update');
        Route::delete('/{bus_daily_status}', [BusDailyStatusController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| API Routes (JSON)
|--------------------------------------------------------------------------
*/
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
    ]);
})->name('get.detal.by.kod');

Route::get('get-bus-km-by-id/{bus_id}', function ($bus_id) {
    $bus = App\Models\Bus::find($bus_id);
    return response()->json(['km' => $bus ? $bus->km : null]);
})->name('get.bus.km.by.id');

Route::get('get-service-templates/{bus_id}', function ($bus_id) {
    $bus = App\Models\Bus::find($bus_id);
    if (!$bus) return response()->json([]);

    $templates = App\Models\ServiceTemplate::all();
    $result = $templates->map(function ($template) use ($bus) {
        $interval = App\Models\BusServiceInterval::where('bus_id', $bus->id)
            ->where('service_template_id', $template->id)->first();
        return [
            'id' => $template->id,
            'name' => $template->name,
            'km_interval' => $interval ? $interval->custom_km_interval : $template->default_km_interval,
            'details' => $template->details,
        ];
    });
    return response()->json($result);
})->name('get.service.templates');

// ========== GÜNDƏLİK KM RECORDS (YENİ) ==========
Route::prefix('daily-km-records')->name('daily-km-records.')->middleware(['role:admin'])->group(function () {
    Route::get('/import', [DailyKmRecordController::class, 'importForm'])->name('import');
    Route::post('/import', [DailyKmRecordController::class, 'import'])->name('import.store');
    Route::get('/create', [DailyKmRecordController::class, 'create'])->name('create');
    Route::post('/', [DailyKmRecordController::class, 'store'])->name('store');
    Route::get('/', [DailyKmRecordController::class, 'index'])->name('index');
    Route::get('/{daily_km_record}', [DailyKmRecordController::class, 'show'])->name('show');
    Route::get('/{daily_km_record}/edit', [DailyKmRecordController::class, 'edit'])->name('edit');
    Route::put('/{daily_km_record}', [DailyKmRecordController::class, 'update'])->name('update');
    Route::delete('/{daily_km_record}', [DailyKmRecordController::class, 'destroy'])->name('destroy');
});
