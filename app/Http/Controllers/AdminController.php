<?php

namespace App\Http\Controllers;

use App\Models\Forecasting;
use App\Models\Salesquotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AdminController extends Controller
{
    function index(Request $request)
    {
        // Mengambil semua data sales
        $salesData = Salesquotation::all();

        // Menghitung jumlah seluruh data sales
        $totalSales = $salesData->count();

        // Menghitung total penjualan (total dari semua total_order)
        $totalSalesAmount = $salesData->sum('total_order');

        // Menghitung total pengiriman yang sudah dikumpulkan
        $totalCollectedDeliveries = Salesquotation::whereIn('sales_status', ['Collected', 'Completed'])->count();

        // Mengelompokkan data penjualan per bulan
        $amountsalesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, SUM(total_order) as total')
                                    ->groupBy('month')
                                    ->pluck('total', 'month')
                                    ->toArray();

        // Mengelompokkan data penjualan per bulan
        $salesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();


        // Mengelompokkan data pengiriman yang sudah dikumpulkan per bulan
        $collectedDeliveriesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereIn('sales_status', ['Collected', 'Completed'])
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();
                                    
        // Menyiapkan data untuk chart
        $totalSalesAmountPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesAmountPerMonth[] = $amountsalesPerMonth[$i] ?? 0;
        }

        // Menyiapkan data untuk chart
        $totalSalesPerMonth = [];
        $totalCollectedDeliveriesPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesPerMonth[] = $salesPerMonth[$i] ?? 0;
            $totalCollectedDeliveriesPerMonth[] = $collectedDeliveriesPerMonth[$i] ?? 0;
        }

        // Mengambil semua parameter unik dari tabel Forecasting
        $selectitem = Forecasting::distinct()->pluck('parameter');

        // Get the selected parameter from the request
        $selectedParameter = $request->input('parameter', '');

        // If a parameter is selected, filter the predictions based on that parameter
        if ($selectedParameter) {
            $predictions = Forecasting::where('parameter', $selectedParameter)->get();
        } else {
            // If no parameter is selected, fetch all predictions
            $predictions = Forecasting::all();
        }

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
            'totalSalesAmountPerMonth' => $totalSalesAmountPerMonth,
            'totalSalesPerMonth' => $totalSalesPerMonth,
            'totalCollectedDeliveriesPerMonth' => $totalCollectedDeliveriesPerMonth,
            'selectitems' => $selectitem,
            'selectedParameter' => $selectedParameter,
            'predictionsData' => $predictions,
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

        // Mengelompokkan data penjualan per bulan
        $amountsalesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, SUM(total_order) as total')
                                    ->groupBy('month')
                                    ->pluck('total', 'month')
                                    ->toArray();

        // Mengelompokkan data penjualan per bulan
        $salesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();


        // Mengelompokkan data pengiriman yang sudah dikumpulkan per bulan
        $collectedDeliveriesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereIn('sales_status', ['Collected', 'Completed'])
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();
                                    
        // Menyiapkan data untuk chart
        $totalSalesAmountPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesAmountPerMonth[] = $amountsalesPerMonth[$i] ?? 0;
        }

        // Menyiapkan data untuk chart
        $totalSalesPerMonth = [];
        $totalCollectedDeliveriesPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesPerMonth[] = $salesPerMonth[$i] ?? 0;
            $totalCollectedDeliveriesPerMonth[] = $collectedDeliveriesPerMonth[$i] ?? 0;
        }

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
            'totalSalesAmountPerMonth' => $totalSalesAmountPerMonth,
            'totalSalesPerMonth' => $totalSalesPerMonth,
            'totalCollectedDeliveriesPerMonth' => $totalCollectedDeliveriesPerMonth,
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

        // Mengelompokkan data penjualan per bulan
        $amountsalesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, SUM(total_order) as total')
                                    ->groupBy('month')
                                    ->pluck('total', 'month')
                                    ->toArray();

        // Mengelompokkan data penjualan per bulan
        $salesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();


        // Mengelompokkan data pengiriman yang sudah dikumpulkan per bulan
        $collectedDeliveriesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereIn('sales_status', ['Collected', 'Completed'])
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();
                                    
        // Menyiapkan data untuk chart
        $totalSalesAmountPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesAmountPerMonth[] = $amountsalesPerMonth[$i] ?? 0;
        }

        // Menyiapkan data untuk chart
        $totalSalesPerMonth = [];
        $totalCollectedDeliveriesPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesPerMonth[] = $salesPerMonth[$i] ?? 0;
            $totalCollectedDeliveriesPerMonth[] = $collectedDeliveriesPerMonth[$i] ?? 0;
        }

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
            'totalSalesAmountPerMonth' => $totalSalesAmountPerMonth,
            'totalSalesPerMonth' => $totalSalesPerMonth,
            'totalCollectedDeliveriesPerMonth' => $totalCollectedDeliveriesPerMonth,
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

        // Mengelompokkan data penjualan per bulan
        $amountsalesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, SUM(total_order) as total')
                                    ->groupBy('month')
                                    ->pluck('total', 'month')
                                    ->toArray();

        // Mengelompokkan data penjualan per bulan
        $salesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();


        // Mengelompokkan data pengiriman yang sudah dikumpulkan per bulan
        $collectedDeliveriesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereIn('sales_status', ['Collected', 'Completed'])
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();
                                    
        // Menyiapkan data untuk chart
        $totalSalesAmountPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesAmountPerMonth[] = $amountsalesPerMonth[$i] ?? 0;
        }

        // Menyiapkan data untuk chart
        $totalSalesPerMonth = [];
        $totalCollectedDeliveriesPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesPerMonth[] = $salesPerMonth[$i] ?? 0;
            $totalCollectedDeliveriesPerMonth[] = $collectedDeliveriesPerMonth[$i] ?? 0;
        }

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
            'totalSalesAmountPerMonth' => $totalSalesAmountPerMonth,
            'totalSalesPerMonth' => $totalSalesPerMonth,
            'totalCollectedDeliveriesPerMonth' => $totalCollectedDeliveriesPerMonth,
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

        // Mengelompokkan data penjualan per bulan
        $amountsalesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, SUM(total_order) as total')
                                    ->groupBy('month')
                                    ->pluck('total', 'month')
                                    ->toArray();

        // Mengelompokkan data penjualan per bulan
        $salesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();


        // Mengelompokkan data pengiriman yang sudah dikumpulkan per bulan
        $collectedDeliveriesPerMonth = Salesquotation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereIn('sales_status', ['Collected', 'Completed'])
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();
                                    
        // Menyiapkan data untuk chart
        $totalSalesAmountPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesAmountPerMonth[] = $amountsalesPerMonth[$i] ?? 0;
        }

        // Menyiapkan data untuk chart
        $totalSalesPerMonth = [];
        $totalCollectedDeliveriesPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalSalesPerMonth[] = $salesPerMonth[$i] ?? 0;
            $totalCollectedDeliveriesPerMonth[] = $collectedDeliveriesPerMonth[$i] ?? 0;
        }

        // Mengirimkan data ke view
        return view('auth.dashboard.dashboard', [
            'salesData' => $salesData,
            'totalSales' => $totalSales,
            'totalSalesAmount' => $totalSalesAmount,
            'totalCollectedDeliveries' => $totalCollectedDeliveries,
            'totalSalesAmountPerMonth' => $totalSalesAmountPerMonth,
            'totalSalesPerMonth' => $totalSalesPerMonth,
            'totalCollectedDeliveriesPerMonth' => $totalCollectedDeliveriesPerMonth,
        ]);
    }

}
