<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\OrderMaster;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $product = Products::paginate(8);
        $countcart = Cart::where('user_id', auth()->id())->count();
        return view('home.userpage',compact('product','countcart'));
    }
}
