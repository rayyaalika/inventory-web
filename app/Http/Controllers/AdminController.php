<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AdminController extends Controller
{
    function index()
    {
        return view('auth.dashboard.dashboard');
    }

    function storeadmin()
    {
        return view('auth.dashboard.dashboard');
    }

    function supplier()
    {
        return view('auth.dashboard.dashboard');
    }

    function customerservice()
    {
        return view('auth.dashboard.dashboard');
    }

    function salesorder()
    {
        return view('auth.dashboard.dashboard');
    }
}
