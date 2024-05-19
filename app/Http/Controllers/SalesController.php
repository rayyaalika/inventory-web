<?php

namespace App\Http\Controllers;

use App\Models\Salesquotation;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('auth.sales.sales');
        // $data['title'] = 'Sales';

        // $salesquotations = Salesquotation::all();
        // return view('auth.product.product', [
        //     'salesquotations' => $salesquotations
        // ], $data);
    }

    public function create_sales(Request $request)
    {
        $request->validate([
            'store_sales' => 'required',

            'transaction_date' => 'required',
            'sq_numbering' => 'required',
            'qty_sales' => 'required',
            'total_order' => 'required',
            'send_date' => 'required',
            'sales_note',
            'sales_status' => 'required',
            'sales_resi' => 'required',
        ]);

        $sales = new Salesquotation([
            'store_sales' => $request->store_sales,
            'transaction_date' => $request->transaction_date,
            'sq_numbering' => $request->sq_numbering,
            'qty_sales' => $request->qty_sales,
            'total_order' => $request->total_order,
            'send_date' => $request->send_date,
            'sales_note' => $request->sales_note,
            'sales_status' => $request->sales_status,
            'sales_resi' => $request->sales_resi,
        ]);

        $sales->save();

        return redirect()->back()->with('success', 'Data berhasil ditambah !');
    }
}
