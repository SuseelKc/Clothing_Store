<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function addtocart(Request $request,$id){

        $product=Products::findOrFail($id);
        $user_id = Auth::user()->id;
        
        $product_exist_id = Cart::where('product_id','=',$id)->where('user_id','=',$user_id)->get('id')->first();
        
        if($product_exist_id)
        {
            $cart = Cart::find($product_exist_id)->first();
            $quantity = $cart->quantity;
            $cart->quantity = $quantity + $request->quantity;
            $cart->price=($cart->rate)*($cart->quantity);
            $cart->save();
            toast('Product added to cart!','success');

            return redirect('/cart');
        }
        else
        {
            $cart= new Cart;
            $cart->product_id=$request->input('product_id');
            $cart->rate=$request->input('price');
            $cart->user_id=$request->input('user_id');
            $cart->quantity=$request->input('quantity');

            $cart->price=($cart->rate)*($cart->quantity);

            $cart->save();
    
            toast('Product added to cart!','success');

            return redirect('/cart');

        }
        
    }

    public function showCart(){
        $cart=Cart::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        return view('home.cart.index',compact('cart','countcart'));
    }

    public function delete($id){

        $cart=Cart::findOrFail($id);
        $cart->delete();

        return redirect('/cart');

    }

}
