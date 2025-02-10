<?php

namespace App\Http\Controllers;

use App\Models\Circulation;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('pages.laporan.index');
    }

    public function show(Request $request)
    {
        $circulations = Circulation::with('book')
            ->where('status', $request->jenisData)
            ->where('tgl_pinjam', '>=', $request->tanggalAwal)
            ->where('tgl_pinjam', '<=', $request->tanggalAkhir)
            ->get();

        return view('pages.laporan.index', compact('circulations'));
    }
}
