<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    //
    public function index(){
        $product=Products::all();
        return view('admin.product.index',compact('product'));
    }


    public function create(){
        // dd('Hre');
        $category=Category::all();
        return view('admin.product.create',compact('category'));
    }

    public function store(ProductFormRequest $request){

        $validatedData=$request->validated();


        $product= new Products;
        $product->name=$validatedData['name'];
        $product->quantity=$validatedData['quantity'];
        $product->price=$validatedData['price'];
        $product->discounted_price=$validatedData['dis_price'];  
        $product->description=$validatedData['description'];
        $product->color=$validatedData['color'];

        $product->category_id=$request->category;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/products/',$filename);
            $product->image= $filename;
            
        }
        $product->save();

       return view('admin.product.index');
    }
    
}
