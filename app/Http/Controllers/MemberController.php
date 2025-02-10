<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {

        $members = Member::all();

        return view('pages.manajemen.anggota.index', compact('members'));
    }

    public function getDataAnggota(Request $request)
    {
        $query = Member::query();

        // Add search functionality
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('telp', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('gender', 'LIKE', '%'.$request->search.'%');
            });
        }

        $members = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($members);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'nama' => ['required', 'string'],
                'jenis_kelamin' => ['required', 'string'],
                'telp' => ['required', 'string'],
                'kelas' => ['nullable', 'string'],
                'cards' => ['nullable', 'string'],
            ]);

            Member::create([
                'name' => $request->nama,
                'gender' => $request->jenis_kelamin,
                'kelas' => $request->kelas,
                'cards' => $request->cards,
                'telp' => $request->telp,
            ]);

            return back()->with('success', 'Data anggota berhasil ditambahkan');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        try {

            Member::where('id', $id)->update([
                'name' => $request->name,
                'gender' => $request->gender,
                'telp' => $request->telp,
                'kelas' => $request->kelas,
                'cards' => $request->cards,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data anggota berhasil diubah',
            ], 200);

        } catch (\Throwable $th) {
            dd($th->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function edit($anggota_id)
    {
        $member = Member::findOrFail($anggota_id);

        return view('pages.manajemen.anggota.edit', compact('member'));
    }

    public function destroy($anggota_id)
    {
        try {
            Member::where('id', $anggota_id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Data anggota berhasil di hapus']);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
