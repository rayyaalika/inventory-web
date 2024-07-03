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

    public function login_action(Request $request)
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
            if (Auth::user() && Auth::user()->role == 'Super Admin'){
                return redirect()->route('superadmin'); 
            } elseif (Auth::user() && Auth::user()->role == 'Store Admin'){
                return redirect('storeadmin');
            } elseif (Auth::user() && Auth::user()->role == 'Supplier'){
                return redirect('supplier');
            } elseif (Auth::user() && Auth::user()->role == 'Cutomer Service'){
                return redirect('customerservice');
            } elseif (Auth::user() && Auth::user()->role == 'Sales Order'){
                return redirect('salesorder');
            }

        } else {
            return redirect('/')->withErrors(['login' => 'Invalid email or password.'])->withInput();
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
