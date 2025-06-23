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


Route::view('/verifikasi', 'laporan.verifikasi')->name('verifikasi.laporan.pelanggaran');
// Route::view('/laporkan', 'laporan.laporkan')->name('laporkan.pelanggaran');
Route::get('/laporkan', [LaporanController::class, 'create'])->name('laporkan.pelanggaran');
Route::view('/riwayat', 'laporan.riwayat')->name('riwayat.pelanggaran');

require __DIR__.'/auth.php';
