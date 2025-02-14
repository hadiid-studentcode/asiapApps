<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{

    public function store($card_id)
    {
        // Cek apakah member ada berdasarkan card_id
        $member = Member::where('cards', $card_id)->first();

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $today = Carbon::today();
        $now = Carbon::now()->toTimeString();

        // Cek apakah ada absensi masuk yang belum ada waktu keluar
        $lastAbsensi = Absensi::where('member_id', $member->id)
            ->whereDate('tanggal', $today)
            ->whereNull('waktu_keluar')
            ->first();

        if ($lastAbsensi) {
            // Jika ada absensi masuk yang belum keluar, update dengan waktu keluar
            $lastAbsensi->waktu_keluar = $now;
            $lastAbsensi->status = false;
            $lastAbsensi->save();
            return response()->json(['message' => 'Absensi keluar berhasil', 'card_id' => $card_id]);
        }

        // Jika tidak ada absensi masuk yang belum keluar, buat absensi masuk baru
        Absensi::create([
            'member_id' => $member->id,
            'tanggal' => $today->toDateString(),
            'waktu_masuk' => $now,
            'status' => true,
        ]);

        return response()->json(['message' => 'Absensi masuk berhasil', 'card_id' => $card_id]);
    }
}
