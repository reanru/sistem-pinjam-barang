<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    UserController,
    BarangController,
    PengaturanController,
    RiwayatPeminjamanController,
    DaftarBarangController,
    PeminjamanBarangController,
    StatusPeminjamanController
};

// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;

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


Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    Route::resource('/pengguna', UserController::class);
    Route::get('datatable-pengguna', [UserController::class, 'datatable'])->name('pengguna.datatable');

    Route::resource('/barang', BarangController::class);
    Route::get('datatable-barang', [BarangController::class, 'datatable'])->name('barang.datatable');

    Route::resource('/pengaturan', PengaturanController::class);

    Route::resource('/riwayat-peminjaman', RiwayatPeminjamanController::class);
    Route::get('datatable-riwayat-peminjaman', [RiwayatPeminjamanController::class, 'datatable'])->name('riwayat-peminjaman.datatable');

    Route::resource('/daftar-barang', DaftarBarangController::class);
    Route::get('datatable-daftar-barang', [DaftarBarangController::class, 'datatable'])->name('daftar-barang.datatable');

    Route::resource('/peminjaman-barang', PeminjamanBarangController::class);
    Route::get('datatable-peminjaman-barang', [PeminjamanBarangController::class, 'datatable'])->name('peminjaman-barang.datatable');

    Route::resource('/status-peminjaman', StatusPeminjamanController::class);

    Route::get('/user/search', [PeminjamanBarangController::class, 'search']);
});



