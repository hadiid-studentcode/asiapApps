<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('pages.settings.index');
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (! $user) {
                return back()->with('error', 'User not found');
            }

            $data = [
                'name' => $request->fullname,
                'email' => $request->email,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return back()->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return back()->with('error', 'Data gagal diubah : '.$th->getMessage());
        }
    }
}
