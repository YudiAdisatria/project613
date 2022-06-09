<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\LainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* 
Route::get('/config-clear', function() {
    Artisan::call('config:clear'); 
    return 'Configuration cache cleared!';
});

Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    return 'Configuration cache cleared! <br> Configuration cached successfully!';
});

Route::get('/cache-clear', function() {
    Artisan::call('cache:clear');
    return 'Application cache cleared!';
});

Route::get('/view-cache', function() {
    Artisan::call('view:cache');
    return 'Compiled views cleared! <br> Blade templates cached successfully!';
});

Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'Compiled views cleared!';
});

Route::get('/route-cache', function() {
    Artisan::call('route:cache');
    return 'Route cache cleared! <br> Routes cached successfully!';
});

Route::get('/route-clear', function() {
    Artisan::call('route:clear');
    return 'Route cache cleared!';
});

Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return 'The links have been created.';
});
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::prefix('dashboard')
    ->middleware(['auth:sanctum', 'admin'])
    ->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/qr', function(){
            return view('asets.qrcode');
        })->name('qrcode');

        Route::resource('users', UserController::class);
        Route::resource('kategoris', KategoriController::class);

        /* EDITAN ROUTE CUSTOM HARUS DIATAS RESOURCE */
        Route::get('asets/{id}/jual', [AsetController::class, 'jual'])->name('asets.jual');
        Route::get('asets/{id}/qr', [AsetController::class, 'qr'])->name('asets.qr');
        Route::put('asets/{id}/save', [AsetController::class, 'save'])->name('asets.save');
        Route::resource('asets', AsetController::class);
        
        Route::get('ruangans/export', [RuanganController::class, 'export'])->name('ruangans.export');
        Route::resource('ruangans', RuanganController::class);

        Route::get('histories/export', [HistoryController::class, 'export'])->name('histories.export');
        Route::resource('histories', HistoryController::class);

        Route::resource('lain', LainController::class);
    });

