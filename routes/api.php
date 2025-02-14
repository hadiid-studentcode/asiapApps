<?php

use App\Http\Controllers\AbsensiController;
use App\Models\Absensi;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use carbon\Carbon;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/total-buku', function () {
    $totalBuku = App\Models\Book::where('status', 'tersedia')->count();

    return response()->json(['totalBuku' => $totalBuku]);
})->name('totalBuku');

Route::get('/total-buku-dipinjam', function () {
    $totalBukuDipinjam = App\Models\Book::where('status', 'dipinjam')->count();

    return response()->json(['totalBukuDipinjam' => $totalBukuDipinjam]);
})->name('totalBukuDipinjam');

Route::get('/total-anggota', function () {
    $totalAnggota = App\Models\Member::count();

    return response()->json(['totalAnggota' => $totalAnggota]);
})->name('totalAnggota');

Route::get('/generate-wa', function () {
    $response = Http::get(env('WHATSAPP_API'));

    return response()->json(['response' => $response->json()]);
})->name('generateWA');


Route::get('/total-buku', function () {
    $totalBuku = App\Models\Book::where('status', 'tersedia')->count();

    return response()->json(['totalBuku' => $totalBuku]);
})->name('totalBuku');


Route::get('/buku-baru', function () {
    $bukuBaru = Book::where('status', 'tersedia')
        ->select('judul', 'isbn', 'pengarang', 'penerbit', 'thn_terbit', 'cover', 'deskripsi', 'created_at')
        ->distinct()
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return response()->json(['bukuBaru' => $bukuBaru]);
})->name('bukuBaru');

Route::get('/absensi/{card_id}', [AbsensiController::class, 'store'])->name('absensi.store');


Route::get('/pengunjung', function () {
    $absensi = Absensi::with('member')->whereDate('tanggal', Carbon::today())
        ->orderBy('updated_at', 'desc')
        ->get();

    return response()->json(['pengunjung' => $absensi]);
})->name('pengunjung');
