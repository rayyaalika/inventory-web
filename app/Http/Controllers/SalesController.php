<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\salesproduct;
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
        $salesproduct = salesproduct::all();
        $stock = Stock::with('product')->get();
        return view('auth.sales.sales', [
            'salesData' => $sales,
            'store' => $store,
            'product' => $product,
            'stock' => $stock,
            'salesproduct' => $salesproduct
        ]);
    }

    public function create_sales(Request $request)
    {
        $salesproductData = json_decode($request->input('salesproduct_data'), true);

        $validated = $request->validate([
            'id_store' => 'required',
            'transaction_date' => 'required',
            'sq_numbering' => 'required',
            'warehouse' => 'required',
            'staff_name' => 'required',
            'customer_name' => 'required',
            'qty_sales' => 'required|integer',
            'salesproduct_data' => 'required|json',
            'socmed_type' => 'nullable',
            'socmed_username' => 'nullable',
            'customer_phone_number' => 'nullable',
            'customer_address' => 'nullable',
            'delivery_company' => 'nullable',
            'payment_receipt' => 'nullable',
            'send_date' => 'nullable|date',
            'sales_note' => 'nullable',
            'resi_number' => 'nullable',
        ]);

        $user_id = Auth::id();

        $sales = Salesquotation::create([
            'id_store' => $validated['id_store'],
            'transaction_date' => $validated['transaction_date'],
            'sq_numbering' => $validated['sq_numbering'],
            'warehouse' => $validated['warehouse'],
            'staff_name' => $validated['staff_name'],
            'customer_name' => $validated['customer_name'],
            'qty_sales' => $validated['qty_sales'],
            'socmed_type' => $validated['socmed_type'],
            'socmed_username' => $validated['socmed_username'],
            'customer_phone_number' => $validated['customer_phone_number'],
            'customer_address' => $validated['customer_address'],
            'delivery_company' => $validated['delivery_company'],
            'payment_receipt' => $validated['payment_receipt'],
            'total_order' => collect($salesproductData)->sum(function ($product) {
                return $product['quantity'] * $product['salesproduct_price'];
            }),
            'send_date' => $validated['send_date'],
            'sales_note' => $validated['sales_note'],
            'resi_number' => $validated['resi_number'],
            'id_user' => $user_id,
        ]);

        $id_sales = $sales->id_sales;

        // dd($salesproductData);
        foreach ($salesproductData as $product) {
            // Ambil id_product dari salesproduct
            $id_product = $product['salesproduct_id'];

            $sales->salesproduct()->create([
                'salesproduct_name' => $product['salesproduct_name'],
                'salesproduct_price' => $product['salesproduct_price'],
                'id_sales' => $id_sales,
                'quantity' => $product['quantity'],
                'id_product' => $id_product, // Tambahkan id_product
            ]);

            // Ambil product terkait
            if ($id_product) {
                // Ambil stock terkait
                $stockData = Stock::where('id_product', $id_product)->first();
                if ($stockData) {
                    // Kurangi wh_stock dengan jumlah penjualan
                    $stockData->wh_stock -= $product['quantity'];
                    // Tambah out_stock dengan jumlah penjualan
                    $stockData->out_stock += $product['quantity'];
                    $stockData->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Data user berhasil diubah!');
    }

    public function getProductPrice($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'price' => $product->product_price,
                'barcode' => $product->product_barcode
            ]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function update_status_sales(Request $request, $id_sales)
    {
        $sales = Salesquotation::find($id_sales);
        $sales->sales_status = $request->sales_status;
        $sales->save();

        return redirect()->back()->with('success', 'Data user berhasil diubah!');
    }

    public function delete_sales($id_sales)
    {
        // Ambil semua produk terkait dengan id_sales
        $salesproducts = Salesproduct::where('id_sales', $id_sales)->get();

        foreach ($salesproducts as $salesproduct) {
            // Ambil id_product dari salesproduct
            $id_product = $salesproduct->id_product;

            // Ambil stock terkait
            $stockData = Stock::where('id_product', $id_product)->first();
            if ($stockData) {
                // Tambah wh_stock dengan jumlah penjualan yang dihapus
                $stockData->wh_stock += $salesproduct->quantity;
                // Kurangi out_stock dengan jumlah penjualan yang dihapus
                $stockData->out_stock -= $salesproduct->quantity;
                $stockData->save();
            }

            // Hapus salesproduct
            $salesproduct->delete();
        }

        // Hapus Salesquotation
        $sales = Salesquotation::find($id_sales);
        // dd('ingin hapus ' . $sales);
        if ($sales) {
            $sales->delete();
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function edit_sales(Request $request, $id_sales)
    {
        $sales = Salesquotation::find($id_sales);
        if (!$sales) {
            return redirect()->back()->with('error', 'Sales not found!');
        }

        $salesproductData = json_decode($request->input('salesproduct_data'), true);

        $validated = $request->validate([
            'id_store' => 'required',
            'transaction_date' => 'required',
            'sq_numbering' => 'required',
            'warehouse' => 'required',
            'staff_name' => 'required',
            'customer_name' => 'required',
            'qty_sales' => 'required|integer',
            'salesproduct_data' => 'required|json',
            'socmed_type' => 'nullable',
            'socmed_username' => 'nullable',
            'customer_phone_number' => 'nullable',
            'customer_address' => 'nullable',
            'delivery_company' => 'nullable',
            'payment_receipt' => 'nullable',
            'send_date' => 'nullable|date',
            'sales_note' => 'nullable',
            'resi_number' => 'nullable',
        ]);

        // Update salesquotation
        $sales->update([
            'id_store' => $validated['id_store'],
            'transaction_date' => $validated['transaction_date'],
            'sq_numbering' => $validated['sq_numbering'],
            'warehouse' => $validated['warehouse'],
            'staff_name' => $validated['staff_name'],
            'customer_name' => $validated['customer_name'],
            'qty_sales' => $validated['qty_sales'],
            'socmed_type' => $validated['socmed_type'],
            'socmed_username' => $validated['socmed_username'],
            'customer_phone_number' => $validated['customer_phone_number'],
            'customer_address' => $validated['customer_address'],
            'delivery_company' => $validated['delivery_company'],
            'payment_receipt' => $validated['payment_receipt'],
            'total_order' => collect($salesproductData)->sum(function ($product) {
                return $product['quantity'] * $product['salesproduct_price'];
            }),
            'send_date' => $validated['send_date'],
            'sales_note' => $validated['sales_note'],
            'resi_number' => $validated['resi_number'],
        ]);

        // Update salesproducts
        Salesproduct::where('id_sales', $id_sales)->delete();
        foreach ($salesproductData as $product) {
            $id_product = $product['salesproduct_id'];

            Salesproduct::create([
                'salesproduct_name' => $product['salesproduct_name'],
                'salesproduct_price' => $product['salesproduct_price'],
                'id_sales' => $id_sales,
                'quantity' => $product['quantity'],
                'id_product' => $id_product,
            ]);

            if ($id_product) {
                $stockData = Stock::where('id_product', $id_product)->first();
                if ($stockData) {
                    $stockData->wh_stock -= $product['quantity'];
                    $stockData->out_stock += $product['quantity'];
                    $stockData->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }
}
