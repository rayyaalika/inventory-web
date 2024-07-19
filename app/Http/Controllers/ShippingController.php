<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\salesproduct;
use App\Models\Salesquotation;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShippingController extends Controller
{
    public function index()
    {
        {
            $sales = Salesquotation::with('salesproduct.product')->orderBy('created_at', 'desc')->paginate(5);
            $store = Store::all();
            $product = Product::all();
            $salesproduct = salesproduct::all();
            $stock = Stock::with('product')->get();
            $pendingAddressSales = Salesquotation::with('salesproduct.product')->where('sales_status', 'Pending Address')->orderBy('created_at', 'desc')->get();
            $pendingShipmentSales = Salesquotation::with('salesproduct.product')->where('sales_status', 'Pending Shipment')->orderBy('created_at', 'desc')->get();
            $waitingListSales = Salesquotation::with('salesproduct.product')->where('sales_status', 'Waiting List')->orderBy('created_at', 'desc')->get();
            $readyToApprovedSales = Salesquotation::with('salesproduct.product')->where('sales_status', 'Ready to Approved')->orderBy('created_at', 'desc')->get();
            $collectedSales = Salesquotation::with('salesproduct.product')->where('sales_status', 'Collected')->orderBy('created_at', 'desc')->get();
            $completedSales = Salesquotation::with('salesproduct.product')->where('sales_status', 'Completed')->orderBy('created_at', 'desc')->get();
            $shippingpost = Salesquotation::with('salesproduct.product')->where('delivery_company', 'POST')->orderBy('created_at', 'desc')->get();
            $shippinghlife = Salesquotation::with('salesproduct.product')->where('delivery_company', 'HLIFE')->orderBy('created_at', 'desc')->get();
            $shippingfm = Salesquotation::with('salesproduct.product')->where('delivery_company', 'FAMILY MART')->orderBy('created_at', 'desc')->get();
            $shippinghct = Salesquotation::with('salesproduct.product')->where('delivery_company', 'HCT')->orderBy('created_at', 'desc')->get();
            $shipping711 = Salesquotation::with('salesproduct.product')->where('delivery_company', '7-11')->orderBy('created_at', 'desc')->get();
            $shippingshopee = Salesquotation::with('salesproduct.product')->where('delivery_company', 'SHOPEE SHOP')->orderBy('created_at', 'desc')->get();
            $shippingoffline = Salesquotation::with('salesproduct.product')->where('delivery_company', 'OFFLINE')->orderBy('created_at', 'desc')->get();
    
            return view('auth.shipping.shipping', [
                'salesData' => $sales,
                'store' => $store,
                'product' => $product,
                'stock' => $stock,
                'salesproduct' => $salesproduct,
                'tab1Sales' => $pendingAddressSales->merge($pendingShipmentSales)->merge($waitingListSales),
                'tab2Sales' => $readyToApprovedSales->merge($collectedSales)->merge($completedSales),
                'post' => $shippingpost,
                'hlife' => $shippinghlife,
                'familymart' => $shippingfm,
                'hct' => $shippinghct,
                'd711' => $shipping711,
                'shopee' => $shippingshopee,
                'offline' => $shippingoffline
            ]);
        }
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

    public function getEditProduct($salesId)
    {
        $sales = Salesquotation::with('salesproduct.product')
            ->where('id_sales', $salesId)
            ->first();
        return response()->json($sales);
    }

    public function index_edit($salesId)
    {
        $sales = Salesquotation::with('salesproduct.product')
            ->where('id_sales', $salesId)
            ->first();
        $store = Store::all();
        $product = Product::all();
        $salesproduct = salesproduct::all();
        $stock = Stock::with('product')->get();

        return view('auth.sales.edit.edit', [
            'sales' => $sales,
            'store' => $store,
            'product' => $product,
            'stock' => $stock,
            'salesproduct' => $salesproduct
        ]);
    }

    public function getProductDetails($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'product' => [
                'product_barcode' => $product->product_barcode,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price
            ]
        ]);
    }

    public function edit_sales(Request $request, $id_sales)
    {
        $sales = Salesquotation::find($id_sales);
        if (!$sales) {
            return redirect()->back()->with('error', 'Sales not found!');
        }

        // Tangani unggahan gambar alamat jika ada
        if ($request->hasFile('address_picture')) {
            // Hapus gambar lama jika ada
            if ($sales->address_picture) {
                unlink(public_path('address_picture/' . $sales->address_picture));
            }
            // Simpan gambar ke penyimpanan
            $imagePath = $request->file('address_picture');
            $imageName = uniqid() . "_" . $imagePath->getClientOriginalName();
            $imagePath->move(public_path('address_picture/'), $imageName);

            // Simpan path gambar ke dalam database
            $validated['address_picture'] = $imageName;
        }

        // Ambil data produk penjualan dari input JSON
        $salesproductData = json_decode($request->input('salesproduct_data'), true);
        // Update atau tambahkan data produk penjualan
        $total_order = 0; // Total order sementara

        // Update atau tambahkan data salesproduct
        foreach ($salesproductData as $product) {
            $existingProduct = $sales->salesproduct->where('id_product', $product['id_product'])->first();
        
            if ($existingProduct) {
                // Jika produk sudah ada dalam penjualan, update kuantitasnya
                $quantityBefore = $existingProduct->quantity; // Kuantitas sebelumnya
                $existingProduct->update([
                    'quantity' => $product['quantity'],
                ]);
        
                // Kurangi atau tambahkan stok berdasarkan perubahan kuantitas
                $quantityDifference = $product['quantity'] - $quantityBefore; // Selisih kuantitas
                $stockData = Stock::where('id_product', $product['id_product'])->first();
                if ($stockData) {
                    $stockData->wh_stock -= $quantityDifference; // Kurangi stok gudang
                    $stockData->out_stock += $quantityDifference; // Tambah stok keluar
                    $stockData->save(); // Simpan perubahan
                }
            } else {
                // Jika produk belum ada dalam penjualan, tambahkan produk baru
                $newProduct = $sales->salesproduct()->create([
                    'salesproduct_name' => $product['product_name'],
                    'salesproduct_price' => $product['salesproduct_price'],
                    'quantity' => $product['quantity'],
                    'id_product' => $product['id_product'],
                ]);
        
                // Kurangi stok saat produk baru ditambahkan
                $stockData = Stock::where('id_product', $product['id_product'])->first();
                if ($stockData) {
                    $stockData->wh_stock -= $product['quantity']; // Kurangi stok gudang
                    $stockData->out_stock += $product['quantity']; // Tambah stok keluar
                    $stockData->save(); // Simpan perubahan
                }
            }
        
            // Hitung total_order
            $total_order += $product['quantity'] * $product['salesproduct_price'];
        }


        // Hapus salesproduct yang tidak ada dalam data baru
        $productsToRemove = $sales->salesproduct->pluck('id_product')->diff(collect($salesproductData)->pluck('id_product'));
        if (!empty($productsToRemove)) {
            foreach ($productsToRemove as $productId) {
                // Ambil kuantitas produk yang dihapus
                $quantityToRemove = $sales->salesproduct()->where('id_product', $productId)->first()->quantity;

                // Kurangi stok
                $stockData = Stock::where('id_product', $productId)->first();
                if ($stockData) {
                    $stockData->wh_stock += $quantityToRemove; // Tambah stok gudang
                    $stockData->out_stock -= $quantityToRemove; // Kurangi stok keluar
                    $stockData->save(); // Simpan perubahan
                }
            }

            // Hapus salesproduct yang tidak ada dalam data baru
            $sales->salesproduct()->whereIn('id_product', $productsToRemove)->delete();
        }


        // Update data penjualan
        $sales->update([
            'customer_name' => $request->input('customer_name'),
            'socmed_type' => $request->input('socmed_type'),
            'socmed_username' => $request->input('socmed_username'),
            'delivery_company' => $request->input('delivery_company'),
            'customer_phone_number' => $request->input('customer_phone_number'),
            'customer_address' => $request->input('customer_address'),
            'address_picture' => $validated['address_picture'] ?? null,
            'send_date' => $request->input('send_date'),
            'sales_note' => $request->input('sales_note'),
            'qty_sales' => $request->input('qty_sales'),
            'payment_receipt' => $request->input('payment_receipt'),
            'resi_number' => $request->input('resi_number'),
            'total_order' => $total_order,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    // Method untuk mengunggah gambar alamat baru
    public function uploadAddressPicture(Request $request, $id_sales)
    {
        $sales = Salesquotation::find($id_sales);
        if (!$sales) {
            return response()->json(['error' => 'Sales not found'], 404);
        }

        // Tangani unggahan gambar alamat jika ada
        if ($request->hasFile('address_picture')) {
            // Hapus gambar lama jika ada
            if ($sales->address_picture) {
                Storage::disk('public')->delete($sales->address_picture);
            }

            // Simpan gambar baru
            $imagePath = $request->file('address_picture')->store('address_pictures', 'public');

            // Simpan path gambar baru ke dalam data penjualan
            $sales->update([
                'address_picture' => $imagePath,
            ]);

            // Berikan respons dengan path baru
            return response()->json(['path' => asset('storage/' . $imagePath)]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function update_payment(Request $request, $id_sales)
    {
        $sales = Salesquotation::find($id_sales);
        // if (!$sales) {
        //     return redirect()->back()->with('error', 'Sales not found!');
        // }
    
        // Validasi input
        $validated = $request->validate([
            'resi_number' => 'nullable|string',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
    
        // Tangani unggahan gambar untuk bukti pembayaran jika ada
        if ($request->hasFile('payment_receipt')) {
            // Hapus gambar lama jika ada
            if ($sales->payment_receipt) {
                Storage::disk('public')->delete($sales->payment_receipt);
            }
    
            // Simpan gambar baru
            $receiptImagePath = $request->file('payment_receipt')->store('payment_receipts', 'public');
    
            // Simpan path gambar baru ke dalam data penjualan
            $validated['payment_receipt'] = $receiptImagePath;
        } else {
            // Jika tidak ada gambar baru diunggah, gunakan gambar yang sudah ada
            $validated['payment_receipt'] = $request->input('existing_payment_receipt');
        }
    
        // Update data penjualan
        $sales->update([
            'resi_number' => $validated['resi_number'],
            'payment_receipt' => $validated['payment_receipt'],
        ]);

        return redirect()->back()->with('success', 'Payment information updated successfully!');
    }

}
