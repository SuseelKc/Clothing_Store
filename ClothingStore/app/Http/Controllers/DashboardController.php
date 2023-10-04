<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderMaster;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        return view('admin.dashboard');
    }
    public function aboutus(){
        $countcart = Cart::where('user_id', auth()->id())->count();
        return view('home.aboutus',compact('countcart'));
    }
}
