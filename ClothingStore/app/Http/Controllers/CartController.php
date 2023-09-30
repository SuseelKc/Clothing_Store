<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function addtocart(Request $request,$id){
        $product=Products::findOrFail($id);
       
        // $category=new Cart;
        // $cart->

        $catgeory= new Category;
        $catgeory->name=$request->input('name');
        $catgeory->


    }
}
