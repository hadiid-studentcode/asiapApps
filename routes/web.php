<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CirculationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogDataController;
use App\Http\Controllers\ManajemenUsers;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');

Route::get('/getDataScan/{id}', function ($id) {
    return response()->json(['id' => $id]);
});

Route::middleware('auth')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/kelola-buku')->name('kelolaBuku.')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/show/{buku_id}', [BookController::class, 'show'])->name('show');
        Route::post('/store', [BookController::class, 'store'])->name('store');
        Route::put('/update/{buku_id}', [BookController::class, 'update'])->name('update');
        Route::DELETE('/destroy/{buku_id}', [BookController::class, 'destroy'])->name('destroy');

        // api

        Route::post('/getData', [BookController::class, 'getDataBuku'])->name('getDataBuku');
    });

    Route::prefix('/data-anggota')->name('dataAnggota.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/show/{anggota_id}', [MemberController::class, 'show'])->name('show');
        Route::post('/store', [MemberController::class, 'store'])->name('store');
        Route::put('/update/{anggota_id}', [MemberController::class, 'update'])->name('update');
        Route::delete('/destroy/{anggota_id}', [MemberController::class, 'destroy'])->name('destroy');
        Route::get('/edit/{anggota_id}', [MemberController::class, 'edit'])->name('edit');

        // api

        Route::post('/getData', [MemberController::class, 'getDataAnggota'])->name('getDataAnggota');

    });

    Route::prefix('/sirkulasi')->name('sirkulasi.')->group(function () {
        Route::get('/', [CirculationController::class, 'index'])->name('index');
        Route::get('/show/{sirkulasi_id}', [CirculationController::class, 'show'])->name('show');
        Route::post('/store', [CirculationController::class, 'store'])->name('store');
        Route::put('/update/{sirkulasi_id}', [CirculationController::class, 'update'])->name('update');
        Route::delete('/destroy/{sirkulasi_id}', [CirculationController::class, 'destroy'])->name('destroy');
        Route::get('/edit/{sirkulasi_id}', [CirculationController::class, 'edit'])->name('edit');
        Route::post('/updateDenda', [CirculationController::class, 'updateDenda'])->name('updateDenda');
        Route::post('/return/{kode_pinjam}', [CirculationController::class, 'returnBook'])->name('return');
        Route::get('/filter', [CirculationController::class, 'filter'])->name('filter');
        Route::post('/extend/{kode_pinjam}', [CirculationController::class, 'extend'])->name('extend');


         // api

         Route::post('/getDataBuku', [CirculationController::class, 'getDataBuku'])->name('getDataBuku');
        Route::post('/loadMore', [CirculationController::class, 'loadMore'])->name('loadMore');
        Route::post('/getDataCirculation', [CirculationController::class, 'getDataCirculation'])->name('getDataCirculation');

    });

    // Route::prefix('/log-data-peminjaman')->name('logDataPeminjaman.')->group(function () {
    //     Route::get('/', [LogDataController::class, 'peminjaman'])->name('index');

    // });
    // Route::prefix('/log-data-pengembalian')->name('logDataPengembalian.')->group(function () {
    //     Route::get('/', [LogDataController::class, 'pengembalian'])->name('index');
    // });

    Route::prefix('/laporan-sirkulasi')->name('laporanSirkulasi.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/show', [LaporanController::class, 'show'])->name('show');
    });

    Route::prefix('/manajemen-users')->name('manajemenUsers.')->group(function () {
        Route::get('/', [ManajemenUsers::class, 'index'])->name('index');
        Route::post('/store', [ManajemenUsers::class, 'store'])->name('store');
        Route::put('/update/{user_id}', [ManajemenUsers::class, 'update'])->name('update');
        Route::delete('/destroy/{user_id}', [ManajemenUsers::class, 'destroy'])->name('destroy');

        // api
        Route::post('/getData', [ManajemenUsers::class, 'getDataUsers'])->name('getDataUsers');

    });

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/update/{id}', [SettingsController::class, 'update'])->name('update');
    });
});

require __DIR__.'/auth.php';
