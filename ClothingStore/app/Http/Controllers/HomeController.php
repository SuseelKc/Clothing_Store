<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class HomeController extends Controller
{
    public function index(){
        $product = Products::paginate(10);
        return view('home.userpage',compact('product'));
    }
}
