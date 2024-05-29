<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Salesquotation;
use App\Models\Store;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        // return view('auth.shipping.shipping');
        $sales = Salesquotation::all();
        $store = Store::all();
        $product = Product::all();
        return view('auth.shipping.shipping', [
            'sales' => $sales,
            'store' => $store,
            'product' => $product,
        ]);
    }

    public function update_status_sales(Request $request, $id_sales) {
        $sales = Salesquotation::find($id_sales);
        $sales->sales_status = $request->sales_status;
        $sales->save();
    
        return redirect()->back()->with('success', 'Data user berhasil diubah!');
    }

}
