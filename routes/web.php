<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    // Pelapor routes (role = 2)
    Route::middleware(['role:2'])->group(function () {
        Route::get('/laporkan', [App\Http\Controllers\LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/laporkan', [App\Http\Controllers\LaporanController::class, 'store'])->name('laporan.store');
        Route::get('/riwayat', [App\Http\Controllers\LaporanController::class, 'history'])->name('laporan.riwayat');
        Route::get('/laporan/{id}', [App\Http\Controllers\LaporanController::class, 'show'])->name('laporan.show');
    });
    
    // Polantas routes (role = 1)
    Route::middleware(['role:1'])->group(function () {
        Route::get('/verifikasi', [App\Http\Controllers\LaporanController::class, 'verification'])->name('laporan.verifikasi');
        Route::get('/laporan/{id}/detail', [App\Http\Controllers\LaporanController::class, 'detail'])->name('laporan.detail');
        Route::post('/laporan/{id}/approve', [App\Http\Controllers\LaporanController::class, 'approve'])->name('laporan.approve');
        Route::post('/laporan/{id}/reject', [App\Http\Controllers\LaporanController::class, 'reject'])->name('laporan.reject');
    });
});

require __DIR__.'/auth.php';
