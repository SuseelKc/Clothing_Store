<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes();
Route::get('/',[HomeController::class,'index']);
// Route::get('/', function () {
   
//     return view('home.userpage');
// });

// Route::get('/dashboard', function () {
//     return view('home.userpage');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// added 
Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function (){


    
    Route::get('/dashboard',[DashboardController::class, 'index']);

    // category
    Route::get('category',[CategoryController::class,'index'])->name('category');
    Route::get('category/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('category/store',[CategoryController::class,'store'])->name('category.store');
    Route::get('category/{id}/edit',[CategoryController::class,'edit'])->name('category.edit');
    Route::post('category/{id}/update',[CategoryController::class,'update'])->name('category.update');
    Route::get('/category/{id}/delete',[CategoryController::class,'delete'])->name('category.delete');

    //products
    Route::get('product',[ProductController::class,'index'])->name('product');
    Route::get('product/create',[ProductController::class,'create'])->name('product.create');
    Route::post('product/store',[ProductController::class,'store'])->name('product.store');
    Route::get('/product/{id}/edit',[ProductController::class,'edit'])->name('product.edit');
    Route::post('/product/{id}/update',[ProductController::class,'update'])->name('product.update');
    Route::get('/productimage/{id}/delete',[ProductController::class,'delImg']);
    
    // orders
    Route::get('/order',[AdminOrderController::class,'index'])->name('order.index');
    Route::get('/order/{id}/view',[AdminOrderController::class,'viewProducts']);
    Route::post('/order/{id}/deliver',[AdminOrderController::class,'orderDelivered']);
    Route::get('/order/{id}/cancel',[AdminOrderController::class,'orderCancelled']);
    Route::get('/order/{id}/delete',[AdminOrderController::class,'orderdelete']);

    //users
    Route::get('/userview',[UserController::class,'index']);
    Route::get('/user/{id}/edit',[UserController::class,'edit']);
    Route::post('/user/{id}/update',[UserController::class,'update']);
    Route::get('/user/{id}/delete',[UserController::class,'delete']);
});

 // cart
 Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/product/{id}/cart', [CartController::class, 'addtocart'])->name('addtocart');
    Route::get('/cart', [CartController::class, 'showCart'])->name('showCart');
    Route::get('/cart/{id}/delete', [CartController::class, 'delete'])->name('deleteCart');
    Route::get('/orders', [OrderController::class, 'showOrders'])->name('orders');
    Route::get('/cash_order',[OrderController::class,'cash_order'])->name('cash_order');

    Route::get('/getaddress',[OrderController::class,'address'])->name('address');
    Route::post('/store-address', [OrderController::class, 'storeaddress'])->name('store_address');
    Route::get('/store-address', [OrderController::class, 'storeaddress']);

    Route::get('/ordered',[OrderController::class,'ordered'])->name('ordered');
    Route::get('/cancelorder/{id}',[OrderController::class,'cancel_order'])->name('cancel_order');

    //payment
    Route::post('/pay', [PaymentController::class, 'pay'])->name('payment');
    Route::get('/pay', [PaymentController::class, 'pay']);
    Route::get('success', [PaymentController::class, 'success']);
    Route::get('error', [PaymentController::class, 'error']);

    //user dashboard
    Route::get('/user/dashboard',[OrderController::class,'userdashboard'])->name('userdashboard');
});

Route::get('/product/{id}/details',[ProductController::class,'product_details'])->name('product_details');
Route::get('/products',[ProductController::class,'view_product'])->name('view_product');
Route::get('/aboutus',[DashboardController::class,'aboutus'])->name('aboutus');
Route::get('/categoryfilter',[ProductController::class,'category_filter'])->name('category_filter');

Route::get('/search-products', [ProductController::class, 'search_products'])->name('search_products');


