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
        $catgeory->product_id=$request->input('product_id');
        $catgeory->rate=$request->input('price');
        $catgeory->user_id=$request->input('user_id');
        

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/products/',$filename);
            $product->image= $filename;
            
        }


        
    }
}
