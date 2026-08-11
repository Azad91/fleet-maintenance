<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
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
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================== BUS ROUTES ====================
// Avtobus işçisi, müdiriyyət və admin üçün baxış
Route::middleware(['auth', 'role:admin,bus,directorate'])->group(function () {
    Route::get('buses', [BusController::class, 'index'])->name('buses.index');
    Route::get('buses/{bus}', [BusController::class, 'show'])->name('buses.show');
    Route::get('buses/search', [BusController::class, 'search'])->name('buses.search');  // YENİ
});

// Admin üçün tam CRUD
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('buses/create', [BusController::class, 'create'])->name('buses.create');
    Route::post('buses', [BusController::class, 'store'])->name('buses.store');
    Route::get('buses/{bus}/edit', [BusController::class, 'edit'])->name('buses.edit');
    Route::put('buses/{bus}', [BusController::class, 'update'])->name('buses.update');
    Route::delete('buses/{bus}', [BusController::class, 'destroy'])->name('buses.destroy');

    Route::get('buses/import', [BusController::class, 'importForm'])->name('buses.import');
    Route::post('buses/import', [BusController::class, 'import'])->name('buses.import.store');
});
// Admin üçün tam CRUD (yarat, redaktə et, sil)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('buses/create', [BusController::class, 'create'])->name('buses.create');
    Route::post('buses', [BusController::class, 'store'])->name('buses.store');
    Route::get('buses/{bus}/edit', [BusController::class, 'edit'])->name('buses.edit');
    Route::put('buses/{bus}', [BusController::class, 'update'])->name('buses.update');
    Route::delete('buses/{bus}', [BusController::class, 'destroy'])->name('buses.destroy');
});

// ==================== COMPLAINT ROUTES ====================
// Şikayət işçisi, müdiriyyət və admin üçün
Route::middleware(['auth', 'role:admin,complaint,directorate'])->group(function () {
    Route::get('complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
});

// Admin və şikayət işçisi üçün tam CRUD
Route::middleware(['auth', 'role:admin,complaint'])->group(function () {
    Route::get('complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('complaints/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::put('complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
    Route::delete('complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');
});

// ==================== WAREHOUSE ROUTES ====================
// Anbar işçisi, müdiriyyət və admin üçün
Route::middleware(['auth', 'role:admin,warehouse,directorate'])->group(function () {
    Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
    Route::get('warehouses/{warehouse}', [WarehouseController::class, 'show'])->name('warehouses.show');
});

// Admin və anbar işçisi üçün tam CRUD
Route::middleware(['auth', 'role:admin,warehouse'])->group(function () {
    Route::get('warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
    Route::post('warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');
    Route::get('warehouses/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
    Route::put('warehouses/{warehouse}', [WarehouseController::class, 'update'])->name('warehouses.update');
    Route::delete('warehouses/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');
});

// ==================== AUTH ROUTES ====================
require __DIR__.'/auth.php';



// ==================== PROFILE ROUTES ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
