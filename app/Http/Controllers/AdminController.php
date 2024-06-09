<?php

namespace App\Http\Controllers;

use App\Models\Salesquotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AdminController extends Controller
{
    function index()
    {
        // Mengambil semua data sales
        $salesData = Salesquotation::all();

        // Menghitung jumlah seluruh data sales
        $totalSales = $salesData->count();

        // Menghitung total penjualan (total dari semua total_order)
        $totalSalesAmount = $salesData->sum('total_order');

        // Menghitung total pengiriman yang sudah dikumpulkan
        $totalCollectedDeliveries = Salesquotation::whereIn('sales_status', ['Collected', 'Completed'])->count();

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
        ]);
    }

    function storeadmin()
    {
        // Mengambil semua data sales
        $salesData = Salesquotation::all();

        // Menghitung jumlah seluruh data sales
        $totalSales = $salesData->count();

        // Menghitung total penjualan (total dari semua total_order)
        $totalSalesAmount = $salesData->sum('total_order');

        // Menghitung total pengiriman yang sudah dikumpulkan
        $totalCollectedDeliveries = Salesquotation::whereIn('sales_status', ['Collected', 'Completed'])->count();

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
        ]);
    }

    function supplier()
    {
        // Mengambil semua data sales
        $salesData = Salesquotation::all();

        // Menghitung jumlah seluruh data sales
        $totalSales = $salesData->count();

        // Menghitung total penjualan (total dari semua total_order)
        $totalSalesAmount = $salesData->sum('total_order');

        // Menghitung total pengiriman yang sudah dikumpulkan
        $totalCollectedDeliveries = Salesquotation::whereIn('sales_status', ['Collected', 'Completed'])->count();

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
        ]);
    }

    function customerservice()
    {
        // Mengambil semua data sales
        $salesData = Salesquotation::all();

        // Menghitung jumlah seluruh data sales
        $totalSales = $salesData->count();

        // Menghitung total penjualan (total dari semua total_order)
        $totalSalesAmount = $salesData->sum('total_order');

        // Menghitung total pengiriman yang sudah dikumpulkan
        $totalCollectedDeliveries = Salesquotation::whereIn('sales_status', ['Collected', 'Completed'])->count();

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
        ]);
    }

    function salesorder()
    {
        // Mengambil semua data sales
        $salesData = Salesquotation::all();

        // Menghitung jumlah seluruh data sales
        $totalSales = $salesData->count();

        // Menghitung total penjualan (total dari semua total_order)
        $totalSalesAmount = $salesData->sum('total_order');

        // Menghitung total pengiriman yang sudah dikumpulkan
        $totalCollectedDeliveries = Salesquotation::whereIn('sales_status', ['Collected', 'Completed'])->count();

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
        ]);
    }

}
