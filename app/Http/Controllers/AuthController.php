<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $data['title'] = 'Masuk';
        return view('guest.login', $data);
    }

    public function login_action(Request $request) //login action class login yang bisa dipanggil ke view
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            // echo "sukses";exit();
            if (Auth::user() && Auth::user()->role == 'Super Admin'){
                return redirect()->route('superadmin'); //superadmin manggil dari name di route
            } elseif (Auth::user() && Auth::user()->role == 'Store Admin'){
                return redirect('storeadmin');
            } elseif (Auth::user() && Auth::user()->role == 'Supplier'){
                return redirect('supplier');
            } elseif (Auth::user() && Auth::user()->role == 'Cutomer Service'){
                return redirect('customerservice');
            } elseif (Auth::user() && Auth::user()->role == 'Sales Order'){
                return redirect('salesorder');
            }

            
            // if ($user->role == 'Super Admin' || $user->role == 'Admin' || $user->role == 'Store Admin' || $user->role == 'Supplier' || $user->role == 'Customer Service' || $user->role == 'Sales Order') {
            //     $request->session()->regenerate();
                
            //     // Redirect sesuai dengan role
            //     if ($user->role == 'Super Admin' || $user->role == 'Admin') {
            //         return redirect('dashboard');
            //     } elseif ($user->role == 'Store Admin') {
            //         return redirect()->route('dashboard');
            //     } elseif ($user->role == 'Supplier') {
            //         return redirect()->route('dashboard');
            //     } elseif ($user->role == 'Customer Service') {
            //         return redirect()->route('dashboard');
            //     } elseif ($user->role == 'Sales Order') {
            //         return redirect()->route('dashboard');
            //     }
            // } else {
            //     return redirect('/')->withErrors('Anda tidak memiliki akses!');
            // }
        } else {
            return redirect('/')->withErrors('Email dan Password anda salah!')->withInput();
        }
    }

    public function signup()
    {
        $data['title'] = 'Register';
        return view('guest.signup', $data);
    }

    public function signup_action(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:admin',
            'password' => 'required',
            'konfirmasi_password' => 'required|same:password',
        ]);
        // $admin = new User([
        //     'nama' => $request->nama,
        //     'email' => $request->email,
        //     'role' => $request->role ?? 'Admin',
        //     'password' => Hash::make($request->password),
        // ]);
        // $admin->save();
        return redirect('/')->with('success', 'Akun berhasil didaftarkan, silahkan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
