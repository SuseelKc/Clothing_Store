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

        $cart= new Cart;
        $cart->product_id=$request->input('product_id');
        $cart->rate=$request->input('price');
        $cart->user_id=$request->input('user_id');
        $cart->quantity=$request->input('quantity');

        $cart->price=($cart->rate)*($cart->quantity);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/carts/',$filename);
            $cart->image= $filename;
            
        }

        $cart->save();


        
    }
}
