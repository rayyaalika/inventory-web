<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        
        return view('auth.user.user', [
            'users' => $users
        ]);
    }

    public function create_user(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
            // 'password_konfirm' => 'required|same:password'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        // $insert =  $user->save();
        // if ($insert) {
        //     return redirect()->back()->with('success', 'Data berhasil ditambah !');
        // } else {
        //     return redirect()->back()->with('failed', 'Data gagal ditambah !');
        // }
        
        $user->save();

        return redirect()->back()->with('success', 'Data berhasil ditambah !');
        // return redirect('/user');
        // return view('auth.user.user');
    }

    public function edit_user(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan!');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data user berhasil diubah!');
    }

    public function delete_user($id_user)
    {

        $user = User::find($id_user);
        $user->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus !');
    }
}
