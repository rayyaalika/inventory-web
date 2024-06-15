<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('guest.login');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class,'login'])->name('login');
    Route::post('login_action', [AuthController::class,'login_action']);
    Route::get('/signup', [AuthController::class,'signup']);
    Route::post('signup_action', [AuthController::class,'signup_action']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('/superadmin', [AdminController::class,'index'])->name('superadmin'); //name buat manggil di controller
    Route::get('/storeadmin', [AdminController::class,'storeadmin'])->name('storeadmin');
    Route::get('/supplier', [AdminController::class,'supplier'])->name('supplier');
    Route::get('/customerservice', [AdminController::class,'customerservice'])->name('customerservice');
    Route::get('/salesorder', [AdminController::class,'salesorder'])->name('salesorder');

    Route::get('/user', [UserController::class,'index']);
    Route::post('/user/create', [UserController::class,'create_user']);
    Route::post('/user/edit/{id}', [UserController::class,'edit_user']);    
    Route::delete('/user/delete/{id}', [UserController::class,'delete_user']);    

    Route::get('/product', [ProductController::class,'index']);
    Route::post('/product/create', [ProductController::class,'create_product']);
    Route::post('/product/restock/{id}', [ProductController::class,'edit_stock']);
    Route::post('/product/edit/{id}', [ProductController::class,'edit_product']);
    Route::delete('/product/delete/{id}', [ProductController::class,'delete_product']);

    Route::get('/sales', [SalesController::class,'index']);
    Route::post('/sales/create', [SalesController::class,'create_sales']);
    Route::post('/sales/purchase-product', [SalesController::class, 'purchaseProduct']);
    Route::post('/sales/sales-status-update/{id}', [SalesController::class, 'update_status_sales']);
    Route::get('/sales/get-product-price/{id}', [SalesController::class, 'getProductPrice']);
    Route::delete('/sales/delete/{id}', [SalesController::class,'delete_sales']);
    Route::get('/sales/get-sales-products/{salesId}', [SalesController::class, 'getEditProduct']);
    Route::post('/sales/edit/{id}', [SalesController::class,'edit_sales']);
    Route::post('/sales/payment/{id}', [SalesController::class, 'update_payment'])->name('sales.payment.update');

    Route::post('/update-stock/{id}', [SalesController::class, 'updateStock']);
    Route::post('/remove-product/{id}', [SalesController::class, 'removeProduct']);



    Route::get('/shipping', [ShippingController::class,'index']);
    Route::post('/shipping/sales-status-update/{id}', [ShippingController::class, 'update_status_sales']);

    Route::get('/profile/{id}', [ProfileController::class,'index']);
    Route::post('/profile/edit/{id}', [ProfileController::class,'edit_profile']); 
});

