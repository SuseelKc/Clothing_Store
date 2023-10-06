<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Models\Category;

class DashboardController extends Controller
{
    //
    public function index(){
        return view('admin.dashboard');
    }
    public function aboutus(){
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.aboutus',compact('countcart','countorder','categories'));
    }
}
