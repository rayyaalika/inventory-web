<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Subcategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::join('categories', 'products.id_category', '=', 'categories.id_category')
        //     ->join('stocks', 'products.id_product', '=', 'stocks.id_product')
        //     ->select('products.*', 'stocks.id_stock')
        //     ->with('categories')
        //     ->get();

        $products = Product::all();
        $categories = Category::all();
        $supplier = Supplier::all();
        $subCategory = Subcategory::all();

        $stocks = Stock::with('product')->get();
        

        return view('auth.product.product', [
            'products' => $products,
            'categories' => $categories,
            'supplier' => $supplier,
            'subCategory' => $subCategory,
            'stocks' => $stocks
        ]);
    }

    public function create_product(Request $request)
    {
        try {
            
            $request->validate([
                'product_name' => 'required',
                'product_barcode' => 'required',
                'product_cost' => 'required',
                'product_price' => 'required',
                'group_unit' => 'required',
                'default_inventory_unit' => 'required',
                'default_sale_unit' => 'required',
                'default_purchase_unit' => 'required',
                'id_supplier' => 'required',
                'id_category' => 'required',
                'id_sub_category' => 'required',
            ]);

            $user_id = Auth::id();

            $product = new Product([
                'product_name' => $request->product_name,
                'product_barcode' => $request->product_barcode,
                'product_cost' => $request->product_cost,
                'product_price' => $request->product_price ,
                'alert_quantity' => $request->alert_quantity,
                'group_unit' => $request->group_unit,
                'default_inventory_unit' => $request->default_inventory_unit,
                'default_sale_unit' => $request->default_sale_unit,
                'default_purchase_unit' => $request->default_purchase_unit,
                'id_supplier' => $request->id_supplier,
                'id_category' => $request->id_category,
                'id_sub_category' => $request->id_sub_category,
                'id_user' => $user_id,
            ]);

            $product->save();

            $stock = new Stock([
                'wh_stock' => 0,
                'in_stock' => 0,
                'out_stock' => 0,
                'real_stock' => 0,
                'alert_stock' => 0,
                'id_product' => $product->id_product
            ]);

            $stock->save();

            return redirect()->back()->with('success', 'Data berhasil ditambah!');
        } catch (\Exception $e) {
            dd([
                'error_message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Gagal menambah data. Silakan coba lagi.');
        }
    }


    public function edit_stock(Request $request, $id)
    {
        $request->validate([
            'wh_stock' => 'required',
            'alert_stock' => 'required',
        ]);

        $stocks = Stock::find($id);
        if (!$stocks) {
            return redirect()->back()->with('error', 'Product tidak ditemukan!');
        }

        $stocks->wh_stock = $request->wh_stock;
        $stocks->alert_stock = $request->alert_stock;

        $stocks->save();

        return redirect()->back()->with('success', 'Data user berhasil diubah!');
    }
    

    public function edit_product(Request $request, $id)
    {
        try {
            $request->validate([
                'product_name' => 'required',
                'product_barcode' => 'required',
                'product_cost' => 'required',
                'product_price' => 'required',
                'group_unit' => 'required',
                'default_inventory_unit' => 'required',
                'default_sale_unit' => 'required',
                'default_purchase_unit' => 'required',
                'id_supplier' => 'required',
                'id_category' => 'required',
                'id_sub_category' => 'required',
            ]);
    
            $products = Product::find($id);
            if (!$products) {
                return redirect()->back()->with('error', 'Product tidak ditemukan!');
            }
            
            $products->product_name = $request->product_name;
            $products->product_barcode = $request->product_barcode;
            $products->product_cost = $request->product_cost;
            $products->product_price = $request->product_price;
            $products->alert_quantity = $request->alert_quantity;
            $products->group_unit = $request->group_unit;
            $products->default_inventory_unit = $request->default_inventory_unit;
            $products->default_sale_unit = $request->default_sale_unit;
            $products->default_purchase_unit = $request->default_purchase_unit;
            $products->product_type = $request->product_type;
            $products->product_brand = $request->product_brand;
            $products->product_color = $request->product_color;
            $products->product_chinese_name = $request->product_chinese_name;
            $products->product_english_name = $request->product_english_name;
            $products->product_code = $request->product_code;
            $products->product_slug = $request->product_slug;
            $products->product_weight = $request->product_weight;
            $products->product_lenght = $request->product_lenght;
            $products->product_height = $request->product_height;
            $products->product_width = $request->product_width;
            $products->product_tax = $request->product_tax;
            $products->tax_method = $request->tax_method;
            $products->link_product = $request->link_product;
            $products->link_video = $request->link_video;
            $products->pre_order_type = $request->pre_order_type;
            $products->branch_owner = $request->branch_owner;
            $products->tumbnail_image = $request->tumbnail_image;
            $products->product_details = $request->product_details;
            
            $products->save();

            return redirect()->back()->with('success', 'Data berhasil ditambah!');
        } catch (\Exception $e) {
            dd([
                'error_message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Gagal menambah data. Silakan coba lagi.');
        }

    }

    public function delete_product($id_product)
    {
        $stock = Stock::find($id_product);
        $stock->delete();

        $product = Product::find($id_product);
        $product->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus !');
    }
}
