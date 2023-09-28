<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function index(){
        $products=Products::all();
        return view('admin.product.index',compact('products'));
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

        return redirect('admin/product')->with('message','Product created sucessfully!');
    }

    public function edit($id){

        // dd($id);

        $product= Products::findOrFail($id);
        $category=Category::all();
        return view('admin.product.edit',compact('product','category'));
       
    }

    public function update(ProductFormRequest $request,$id){

        $validatedData= $request->validated();

        $product = Products::findOrFail($id);
        $product->name=$validatedData['name'];
        $product->quantity=$validatedData['quantity'];
        $product->price=$validatedData['price'];
        $product->discounted_price=$validatedData['dis_price'];  
        $product->description=$validatedData['description'];
        $product->color=$validatedData['color'];
        $product->category_id=$request->category;
        
        if($request->hasFile('image')){

            $path='uploads/products/'.$product->image;
            if(File::exists($path)){
                File::delete($path);
            }
            
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/products/',$filename);
            $product->image= $filename;
            
        }
        $product->update();

        return redirect('admin/product')->with('message','Product Updated sucessfully!');
    }
    public function product_details($id){
        $product = Products::find($id);
        return view('home.details',compact('product'));
    }
   
    
  
}
