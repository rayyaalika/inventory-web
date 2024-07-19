<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\salesproduct;
use App\Models\Salesquotation;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Salesquotation::with('salesproduct.product')->orderBy('created_at', 'desc')->get();
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
        $tab1Sale = $pendingAddressSales->merge($pendingShipmentSales)->merge($waitingListSales);
        $tab2Sale = $readyToApprovedSales->merge($collectedSales)->merge($completedSales);

        return view('auth.sales.sales', [
            'salesData' => $sales,
            'store' => $store,
            'product' => $product,
            'stock' => $stock,
            'salesproduct' => $salesproduct,
            'tab1Sales' => $tab1Sale,
            'tab2Sales' => $tab2Sale
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
            'address_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delivery_company' => 'nullable',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'send_date' => 'nullable|date',
            'sales_note' => 'nullable',
            'resi_number' => 'nullable',
        ]);

        $user_id = Auth::id();

        // Tangani unggahan gambar jika ada
        if ($request->hasFile('address_picture')) {
            // Simpan gambar ke penyimpanan
            $imagePath = $request->file('address_picture');
            $imageName = uniqid() . "_" . $imagePath->getClientOriginalName();
            $imagePath->move(public_path('address_picture/'), $imageName);

            // Simpan path gambar ke dalam database
            $validated['address_picture'] = $imageName;
        }

        // Tangani unggahan gambar jika ada
        if ($request->hasFile('payment_receipt')) {
            // Simpan gambar ke penyimpanan
            $imagePath = $request->file('payment_receipt');
            $imageName = uniqid() . "_" . $imagePath->getClientOriginalName();
            $imagePath->move(public_path('payment_receipt/'), $imageName);

            // Simpan path gambar ke dalam database
            $validated['payment_receipt'] = $imageName;
        }

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
            'address_picture' => $validated['address_picture'] ?? null,
            'delivery_company' => $validated['delivery_company'],
            'payment_receipt' => $validated['payment_receipt'] ?? null,
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
