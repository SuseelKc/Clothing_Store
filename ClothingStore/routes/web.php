<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

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

Route::get('/', function () {
    // return view('welcome');
    return view('home.userpage');
});

Route::get('/dashboard', function () {
    return view('home.userpage');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});