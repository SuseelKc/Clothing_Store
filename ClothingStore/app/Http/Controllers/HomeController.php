<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class HomeController extends Controller
{
    public function index(){
        $product = Products::all();
        return view('home.userpage',compact('product'));
    }
}
