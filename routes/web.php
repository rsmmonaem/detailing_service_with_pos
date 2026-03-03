<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\PosController@index')->name('pos.index');
Route::post('/pos', 'App\Http\Controllers\PosController@store')->name('pos.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::get('/sales', 'App\Http\Controllers\Admin\SaleController@index')->name('sales.index');
    Route::get('/sales/export', 'App\Http\Controllers\Admin\SaleController@export')->name('sales.export');
    Route::get('/reports/daily', 'App\Http\Controllers\Admin\DashboardController@dailyReport')->name('reports.daily');
    Route::get('/settings', 'App\Http\Controllers\Admin\SettingsController@index')->name('settings.index');
    Route::post('/settings', 'App\Http\Controllers\Admin\SettingsController@update')->name('settings.update');
    
    // Services CRUD
    Route::resource('services', 'App\Http\Controllers\Admin\ServiceController');
    
    // QR Codes CRUD
    Route::resource('qr_codes', 'App\Http\Controllers\Admin\QrCodeController');
});
