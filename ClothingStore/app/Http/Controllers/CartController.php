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
    
        if ($request->input('selectedSize')) {
            $selectedSize = $request->input('selectedSize');
            $cartItem = Cart::where('product_id', $id)->where('user_id', $user_id)->where('size_id', $selectedSize)->first();

        } else {
            $cartItem = Cart::where('product_id', $id)->where('user_id', $user_id)->first();
        }
    
        if ($cartItem) {
            $quantityInCart = $cartItem->quantity;
            $availableQuantity = $product->quantity;
    
            $remainingQuantity = $availableQuantity - $quantityInCart; 
    
            if ($request->quantity <= $remainingQuantity) {
                $cartItem->quantity += $request->quantity;
                $cartItem->rate = $product->discounted_price ?: $product->price; // Use discounted price if available, otherwise use regular price
                $cartItem->price = $cartItem->rate * $cartItem->quantity;
                $cartItem->save();
                toast('Product added to cart!', 'success');
                return redirect('/cart');
            } else {
                                
                $errorMessage = "You can add at most {$remainingQuantity} more of this product.";
                return redirect()->back()->with('error', $errorMessage);
            }
        } else {
            if ($request->quantity <= $product->quantity) {
                $cart = new Cart;
                $cart->product_id = $id;
                $cart->rate = $product->discounted_price ?: $product->price; // Use discounted price if available, otherwise use regular price
                $cart->user_id = $user_id;
                $cart->quantity = $request->quantity;
                $cart->price = $cart->rate * $cart->quantity;

    
                if ($request->input('selectedSize')) {
                    $selectedSize = $request->input('selectedSize');
                    $cart->size_id = $selectedSize;
                
                    //size
                    $size = Sizes::findOrFail($selectedSize);
                    $sizeName= $size->size;
                    $productSizeQty=$product->$sizeName;
                    
                    // 
                    if($productSizeQty<($request->quantity)){
                        

                        $errorMessage = " {$product->name} product '{$sizeName}' Size out of stock ordered! Order less than {$productSizeQty}";
                        return redirect()->back()->with('error', $errorMessage);
                    }

                // 

                }
    
                $cart->save();
                toast('Product added to cart!', 'success');
                return redirect('/cart');
            } else {
                $errorMessage = "You can add at most {$product->quantity} of this product.";
                return redirect()->back()->with('error', $errorMessage);
            }
        }
    }
    
    

    public function showCart()
    {
       
        $user = Auth::user();
        $categories = Category::all();
        
        // Get the user's cart items
        $cart = Cart::where('user_id', $user->id)->get();
        
        // Check if the products in the cart are still available in the required quantity
        foreach ($cart as $cartItem) {
          
            $product = Products::find($cartItem->product_id);
            // 
            // dd( $product);
            // dd($product->size_id);
            $size=Sizes::where('id',$cartItem->size_id)->first();
            // dd($size);
            if(!is_null($size)){
                // dd("here");
                 $sizeName=$size->size;
                 $productSizeQty=$product->$sizeName;

                 if($product && $cartItem->quantity > $productSizeQty){
                    $cartItem->delete();
                } 
            }
                               
            if ($product && $cartItem->quantity > $product->quantity) {
                // Product no longer available in the required quantity, remove the cart item
                              
                    $cartItem->delete();
            }
        }
        $cart = Cart::where('user_id', $user->id)->get();
        
        $countcart = Cart::where('user_id', $user->id)->count();
        $countorder = OrderMaster::where('user_id', $user->id)->count();
        
        return view('home.cart.index', compact('cart', 'countcart', 'countorder', 'categories'));
    }
    

    public function delete($id){

        $cart=Cart::findOrFail($id);
        $cart->delete();

        return redirect('/cart');

    }

}
