<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\DashboardController;

// ============ PUBLIK ============
Route::view('/', 'home')->name('home');
Route::view('/verifikasi', 'verifikasi')->name('verifikasi');
// Route::post('/verifikasi/cek', function () {
//     // TODO: proses dekripsi batch + serial, lalu redirect ke salah satu view di bawah
//     return redirect()->route('verifikasi.hasil-asli');
// })->name('verifikasi.cek');
Route::post('/verifikasi/cek', [VerifikasiController::class, 'cek'])->name('verifikasi.cek');
Route::view('/verifikasi/hasil-asli', 'hasil-asli')->name('verifikasi.hasil-asli');
Route::view('/verifikasi/hasil-warning', 'hasil-warning')->name('verifikasi.hasil-warning');
Route::view('/verifikasi/hasil-invalid', 'hasil-invalid')->name('verifikasi.hasil-invalid');


// ============ AUTH ADMIN ============
Route::view('/admin/login', 'admin.login')->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
// Route::view('/admin/register', 'admin.register')->name('admin.register');
// Route::post('/admin/register', function () { /* TODO */ })->name('admin.register.submit');
// Route::view('/admin/lupa-password', 'admin.forgot-password')->name('admin.password.request');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


// ============ ADMIN (harus login) ============
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Produk
    Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
    Route::view('/produk/tambah', 'admin.produk.create')->name('produk.create');
    Route::post('/produk', [ProductController::class, 'store'])->name('produk.store');
    Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{product}', [ProductController::class, 'update'])->name('produk.update');
    Route::get('/produk/{product}', [ProductController::class, 'show'])->name('produk.show');
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])->name('produk.destroy');

    // Produksi Baru (Buat Batch & Generate QR) - HALAMAN PENUH, bukan modal
    Route::get('/produk/{product}/produksi-baru', [ProductController::class, 'produksiBaru'])->name('produk.produksi-baru');
    Route::post('/produk/{product}/produksi-baru', [ProductController::class, 'storeProduksiBaru'])->name('produk.produksi-baru.store');
    Route::get('/batch/produksi-baru', [BatchController::class, 'produksiBaruForm'])->name('batch.produksi-baru');
    Route::post('/batch/produksi-baru', [BatchController::class, 'storeProduksiBaruMulti'])->name('batch.produksi-baru.store');


    // Batch Produksi (hanya arsip, tanpa tombol tambah)
    Route::get('/batch', [BatchController::class, 'index'])->name('batch.index');
    Route::get('/batch/{batch}', [BatchController::class, 'show'])->name('batch.show');
    Route::delete('/batch/{batch}', [BatchController::class, 'destroy'])->name('batch.destroy');
    Route::get('/batch/{batch}/qr/{qr}', [BatchController::class, 'qrShow'])->name('batch.qr-show');
       Route::get('/batch/{batch}/cetak-label', [BatchController::class, 'cetakLabel'])->name('batch.cetak-label');
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});
