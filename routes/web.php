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
        Route::view('/verifikasi', 'laporan.verifikasi')->name('laporan.verifikasi');
    });
});

require __DIR__.'/auth.php';
