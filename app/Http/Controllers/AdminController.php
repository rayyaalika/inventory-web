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
        // echo "<h1>" . Auth::user()->name . "</h1>";
        // echo "<a href='/logout'>Logout >></a>";
    }

    function storeadmin()
    {
        echo "<h1>" . Auth::user()->name . "</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function supplier()
    {
        echo "<h1>" . Auth::user()->name . "</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function customerservice()
    {
        echo "<h1>" . Auth::user()->name . "</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function salesorder()
    {
        echo "<h1>" . Auth::user()->name . "</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }
}
