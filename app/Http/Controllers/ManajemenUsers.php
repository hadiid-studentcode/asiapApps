<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManajemenUsers extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('pages.manajemen.users.index', compact('users'));
    }

    public function getDataUsers(Request $request)
    {
        $search = $request->search;

        $query = User::orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('username', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        $users = $query->paginate(10);

        return response()->json($users);
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required | unique:users',
                'email' => 'required|email',
                'password' => 'required',
            ]);
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return back()->with('success', 'User berhasil ditambahkan');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $request->validate([

                'email' => 'email',

            ]);
            User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil diupdate',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'User gagal diupdate :'.$th->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            User::find($id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dihapus',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'User gagal dihapus :'.$th->getMessage(),
            ]);
        }
    }
}
