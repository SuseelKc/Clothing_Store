<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use App\Models\OrderMaster;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $order=OrderMaster::count();
        $user = User::where('usertype', 0)->count();
        $processing = OrderMaster::where('delivery_status', 1)->count();
        $totalrevenue = OrderMaster::where('delivery_status', 2)->sum('totalamount');
        $delivered = OrderMaster::where('delivery_status', 2)->count();
        $cancelled = OrderMaster::where('delivery_status', 3)->count();
        $product=Products::count();
        $category=Category::count();
        return view('admin.dashboard',compact('order','product','category','user','processing','delivered','cancelled','totalrevenue'));
    }
    public function aboutus(){
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.aboutus',compact('countcart','countorder','categories'));
    }
}
