<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Products;
use App\Models\OrderMaster;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $order=OrderMaster::count();
        $product=Products::count();
        return view('admin.dashboard',compact('order','product'));
    }
    public function aboutus(){
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.aboutus',compact('countcart','countorder','categories'));
    }
}
