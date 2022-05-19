<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\HistoryController;
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
    });

