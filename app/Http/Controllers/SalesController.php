<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Salesquotation;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        // return view('auth.sales.sales');

        $sales = Salesquotation::all();
        $store = Store::all();
        $product = Product::all();
        $stock = Stock::with('product')->get();
        return view('auth.sales.sales', [
            'sales' => $sales,
            'store' => $store,
            'product' => $product,
            'stock' => $stock
        ]);
    }

    public function create_sales(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required',
            'sq_numbering' => 'required',
            'warehouse' => 'required',
            'staff_name' => 'required',
            'customer_name' => 'required',
            'id_store' => 'required',
            'products' => 'required|array',
        ]);

        $user_id = Auth::id();

        $sales = new Salesquotation([
            'transaction_date' => $request->transaction_date,
            'sq_numbering' => $request->sq_numbering,
            'warehouse' => $request->warehouse,
            'staff_name' => $request->staff_name,
            'socmed_type' => $request->socmed_type,
            'socmed_username' => $request->socmed_username,
            'customer_name' => $request->customer_name,
            'customer_phone_number' => $request->customer_phone_number,
            'customer_address' => $request->customer_address,
            'address_picture' => $request->address_picture,
            'delivery_company' => $request->delivery_company,
            'payment_receipt' => $request->payment_receipt,
            'qty_sales' => $request->qty_sales,
            'total_order' => $request->total_order,
            'send_date' => $request->send_date,
            'sales_note' => $request->sales_note,
            'resi_number' => $request->resi_number,
            'id_store' => $request->id_store,
            'id_product' => $request->id_product,
            'id_user' => $user_id,
        ]);

        $sales->save();

        foreach ($request->products as $product) {
            $sales->products()->attach($product['id_product'], ['qty_sales' => $product['qty_sales']]);
        }

        return redirect()->back()->with('success', 'Data berhasil ditambah !');
    }

    public function update_status_sales(Request $request, $id_sales) {
        $sales = Salesquotation::find($id_sales);
        $sales->sales_status = $request->sales_status;
        $sales->save();
    
        return redirect()->back()->with('success', 'Data user berhasil diubah!');
    }

}
