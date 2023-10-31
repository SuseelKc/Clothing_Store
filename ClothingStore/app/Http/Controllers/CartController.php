<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CartController extends Controller
{
    //
    public function addtocart(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $user_id = Auth::user()->id;
    
        $cartItem = Cart::where('product_id', $id)->where('user_id', $user_id)->first();
    
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
