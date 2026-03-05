<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

Route::get('/', [PosController::class, 'index'])->middleware(['auth'])->name('pos.index');
Route::post('/pos', [PosController::class, 'store'])->middleware(['auth'])->name('pos.store');
Route::get('/pos/suggestions', [PosController::class, 'suggestions'])->middleware(['auth'])->name('pos.suggestions');
Route::get('/pos/report/daily', [PosController::class, 'dailyReport'])->middleware(['auth'])->name('pos.report.daily');
Route::get('/pos/print/{sale}', [PosController::class, 'printReceipt'])->middleware(['auth'])->name('pos.print');

// Alias for Breeze default redirect
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export');
    Route::get('/reports/daily', [DashboardController::class, 'dailyReport'])->name('reports.daily');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Services CRUD
    Route::resource('services', ServiceController::class);
    
    // QR Codes CRUD
    Route::resource('qr_codes', QrCodeController::class);

    // Permission System CRUD
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
