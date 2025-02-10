<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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
