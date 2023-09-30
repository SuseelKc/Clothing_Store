<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function addtocart($id){
        if (Auth::check()) {
            $category=new Cart;
        // $cart->
        } else {
            return redirect()->route('login');
        }
    }
}
