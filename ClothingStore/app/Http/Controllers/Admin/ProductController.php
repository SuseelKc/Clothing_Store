<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
// use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    //
    public function index(){
        // $product=Product::all();
        return view('admin.product.index');
    }

    public function create(){
        return view('admin.product.create');
    }
    
}
