<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sizes;
use App\Models\Category;
use App\Models\Products;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function addtocart(Request $request, $id)
    {
       
        $product = Products::findOrFail($id);
        $user_id = Auth::user()->id;

        // $size_id=Sizes::where('product_id',$id)-->id();
        // dd($size_id);

        if($request->input('selectedSize')){
        $selectedSize = $request->input('selectedSize');
        $cartItem = Cart::where('product_id', $id)->where('user_id', $user_id)->where('size_id', $selectedSize)->first();
        }    
        else{
            $cartItem = Cart::where('product_id', $id)->where('user_id', $user_id)->first();
        }
    
        // $cartItem = Cart::where('product_id', $id)->where('user_id', $user_id)->first();
    
        if ($cartItem) {
            $quantityInCart = $cartItem->quantity;
            $availableQuantity = $product->quantity;
    
            $remainingQuantity = $availableQuantity - $quantityInCart;
    
            if ($request->quantity <= $remainingQuantity) {
                $cartItem->quantity += $request->quantity;
                $cartItem->price = $cartItem->rate * $cartItem->quantity;
                $cartItem->save();
                toast('Product added to cart!', 'success');
                return redirect('/cart');
            } else {
                $errorMessage = "You can add at most {$product->quantity} of this product.";
                return redirect()->back()->with('error', $errorMessage);
                // toast("You can add at most {$remainingQuantity} more of this product.", 'error');
            }
    
            // return redirect('/cart');
        } else {
            // New item in the cart
            if ($request->quantity <= $product->quantity) {
                $cart = new Cart;
                $cart->product_id = $id;
                $cart->rate = $product->price; // Assuming the product price is used
                $cart->user_id = $user_id;
                $cart->quantity = $request->quantity;
                $cart->price = $cart->rate * $cart->quantity;

                // size
                if($request->input('selectedSize')){
                    $selectedSize = $request->input('selectedSize');
                    // dd($selectedSize);
                    $cart->size_id = $selectedSize;
                    // dd($cart->size);                    
                }
                // 

                $cart->save();
                return redirect('/cart');
                toast('Product added to cart!', 'success');
            } else {
                $errorMessage = "You can add at most {$product->quantity} of this product.";
                return redirect()->back()->with('error', $errorMessage);
                // toast("You can add at most {$product->quantity} of this product.", 'error');
            }
    
            // return redirect('/cart');
        }
    }
    

    public function showCart(){
        $categories = Category::all();
        $cart=Cart::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.cart.index',compact('cart','countcart','countorder','categories'));
    }

    public function delete($id){

        $cart=Cart::findOrFail($id);
        $cart->delete();

        return redirect('/cart');

    }

}
