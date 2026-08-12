<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\DailyKmController;
use App\Http\Controllers\MotorOilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Hər kəs üçün açıq)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze ilə gələn)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Giriş etmiş istifadəçilər üçün)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Bus Routes (Avtobuslar)
    |--------------------------------------------------------------------------
    */
    Route::prefix('buses')->name('buses.')->group(function () {

        // YALNIZ ADMIN üçün CRUD + Import (ƏVVƏL)
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/import', [BusController::class, 'importForm'])->name('import');
            Route::post('/import', [BusController::class, 'import'])->name('import.store');
            Route::get('/create', [BusController::class, 'create'])->name('create');
            Route::post('/', [BusController::class, 'store'])->name('store');
            Route::get('/{bus}/edit', [BusController::class, 'edit'])->name('edit');
            Route::put('/{bus}', [BusController::class, 'update'])->name('update');
            Route::delete('/{bus}', [BusController::class, 'destroy'])->name('destroy');
        });

        // ADMIN, BUS, DIRECTORATE üçün baxış (SONRA)
        Route::middleware(['role:admin,bus,directorate'])->group(function () {
            Route::get('/', [BusController::class, 'index'])->name('index');
            Route::get('/search', [BusController::class, 'search'])->name('search');
            Route::get('/{bus}', [BusController::class, 'show'])->name('show');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Complaint Routes (Şikayətlər)
    |--------------------------------------------------------------------------
    */
    Route::prefix('complaints')->name('complaints.')->group(function () {

        // ADMIN və COMPLAINT üçün tam CRUD (ƏVVƏL)
        Route::middleware(['role:admin,complaint'])->group(function () {
            Route::get('/import', [ComplaintController::class, 'importForm'])->name('import');
            Route::post('/import', [ComplaintController::class, 'import'])->name('import.store');
            Route::post('/', [ComplaintController::class, 'store'])->name('store');
            Route::get('/{complaint}/edit', [ComplaintController::class, 'edit'])->name('edit');
            Route::put('/{complaint}', [ComplaintController::class, 'update'])->name('update');
            Route::delete('/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');
        });

        // ADMIN, COMPLAINT, DIRECTORATE üçün baxış (SONRA)
        Route::middleware(['role:admin,complaint,directorate'])->group(function () {
            Route::get('/', [ComplaintController::class, 'index'])->name('index');
            Route::get('/search', [ComplaintController::class, 'search'])->name('search');
            Route::get('/create', [ComplaintController::class, 'create'])->name('create');
            Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('show');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Complaint Types Routes (Şikayət Növləri)
    |--------------------------------------------------------------------------
    */
    Route::prefix('complaint-types')->name('complaint-types.')->middleware(['role:admin'])->group(function () {
        Route::get('/import', [ComplaintTypeController::class, 'importForm'])->name('import');
        Route::post('/import', [ComplaintTypeController::class, 'import'])->name('import.store');
        Route::resource('/', ComplaintTypeController::class)->parameters(['' => 'complaint_type']);
    });

    /*
    |--------------------------------------------------------------------------
    | Warehouse Routes (Anbar)
    |--------------------------------------------------------------------------
    */
    Route::prefix('warehouses')->name('warehouses.')->group(function () {

        // ADMIN və WAREHOUSE üçün tam CRUD (ƏVVƏL)
        Route::middleware(['role:admin,warehouse'])->group(function () {
            Route::get('/import', [WarehouseController::class, 'importForm'])->name('import');
            Route::post('/import', [WarehouseController::class, 'import'])->name('import.store');
            Route::get('/create', [WarehouseController::class, 'create'])->name('create');
            Route::post('/', [WarehouseController::class, 'store'])->name('store');
            Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit');
            Route::put('/{warehouse}', [WarehouseController::class, 'update'])->name('update');
            Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
        });

        // ADMIN, WAREHOUSE, DIRECTORATE üçün baxış (SONRA)
        Route::middleware(['role:admin,warehouse,directorate'])->group(function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('index');
            Route::get('/search', [WarehouseController::class, 'search'])->name('search');
            Route::get('/{warehouse}', [WarehouseController::class, 'show'])->name('show');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Daily KM Routes (Gündəlik KM)
    |--------------------------------------------------------------------------
    */
    Route::prefix('daily-km')->name('daily-km.')->middleware(['role:admin'])->group(function () {
        Route::get('/import', [DailyKmController::class, 'importForm'])->name('import');
        Route::post('/import', [DailyKmController::class, 'import'])->name('import.store');
        Route::resource('/', DailyKmController::class)->parameters(['' => 'daily_km']);
    });

    /*
    |--------------------------------------------------------------------------
    | Motor Oil Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('motor-oil')->name('motor-oil.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', [MotorOilController::class, 'index'])->name('index');
        Route::get('/search', [MotorOilController::class, 'search'])->name('search');
        Route::get('/import', [MotorOilController::class, 'importForm'])->name('import');
        Route::post('/import', [MotorOilController::class, 'import'])->name('import.store');
    });
});

/*
|--------------------------------------------------------------------------
| API Routes (JSON Cavablar)
|--------------------------------------------------------------------------
*/
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

Route::get('get-service-templates/{bus_id}', function ($bus_id) {
    $bus = App\Models\Bus::find($bus_id);
    if (!$bus) {
        return response()->json([]);
    }

    $templates = App\Models\ServiceTemplate::all();

    $result = $templates->map(function ($template) use ($bus) {
        $interval = App\Models\BusServiceInterval::where('bus_id', $bus->id)
            ->where('service_template_id', $template->id)
            ->first();

        return [
            'id' => $template->id,
            'name' => $template->name,
            'km_interval' => $interval ? $interval->custom_km_interval : $template->default_km_interval,
            'details' => $template->details,
        ];
    });

    return response()->json($result);
})->name('get.service.templates');

Route::get('get-motor-oil-kms', function () {
    $kms = App\Models\MotorOilDetail::select('km')->distinct()->orderBy('km')->pluck('km');
    return response()->json($kms);
})->name('get.motor.oil.kms');

Route::get('get-motor-oil-details/{km}', function ($km) {
    $details = App\Models\MotorOilDetail::where('km', $km)->get();
    return response()->json($details);
})->name('get.motor.oil.details');

Route::get('get-service-template-by-km/{km}', function ($km) {
    $template = App\Models\ServiceTemplate::where('default_km_interval', $km)->first();
    return response()->json($template);
})->name('get.service.template.by.km');
