<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Products;
use App\Models\OrderMaster;
use App\Models\ProductImage;
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
        $category=Category::all();
        return view('admin.product.create',compact('category'));
    }

    public function store(ProductFormRequest $request){

        $validatedData=$request->validated();

        $name=$validatedData['name'];
        $existingName=Products::where('name',$name)->first();
        if($existingName){
            toast('Product exists!','error');  
            return redirect('admin/product/create');
        }

        $product= new Products;
        $product->name=$validatedData['name'];
        $product->quantity=$validatedData['quantity'];
        $product->price=$validatedData['price'];
        $product->discounted_price=$validatedData['dis_price'];  
        $product->description=$validatedData['description'];
        $product->color=$validatedData['color'];
        $product->tags=$validatedData['tags'];

        $product->category_id=$request->category;
        $product->save();

        if($request->hasFile('image')){

            $i=1;
            foreach($request->file('image') as $image){
              
                $extension=$image->getClientOriginalExtension();
                $filename=time().$i++.'.'.$extension;
                $image->move('uploads/products/',$filename);
                $filepath='uploads/products/'.$filename;

                $prodImage= new ProductImage;
                $prodImage->image=$filepath;
                $prodImage->product_id=$product->id;
                $prodImage->save();

            }           
        }       
        toast('Product created sucessfully!','success');

        return redirect('admin/product');
        // ->with('message','Product created sucessfully!');
    }

    public function edit($id){

        $product= Products::findOrFail($id);
        $category=Category::all();

        $prodImage=ProductImage::where('product_id',$id)->get();
        

        return view('admin.product.edit',compact('product','category','prodImage'));
       
    }

    public function update(ProductFormRequest $request,$id){

        $validatedData= $request->validated();

        $product = Products::findOrFail($id);

        // 
        if(($product->name !== $validatedData['name']) && Products::where('name', $validatedData['name'])->exists()){
            toast('Product exists!','error');  
            return back();
        }
        // 

        $product->name=$validatedData['name'];
        $product->quantity=$validatedData['quantity'];
        $product->price=$validatedData['price'];
        $product->discounted_price=$validatedData['dis_price'];  
        $product->description=$validatedData['description'];
        $product->color=$validatedData['color'];
        $product->tags=$validatedData['tags'];
        $product->category_id=$request->category;
        $product->update();

        
        if($request->hasfile('image')){

            $prodImg=ProductImage::where('product_id',$id)->get();

            foreach($prodImg as $prodImg){
                $imagepath=$prodImg->image;
                File::delete($imagepath); 
            }

            $i=1;
            foreach($request->file('image') as $image){
              
                $extension=$image->getClientOriginalExtension();
                $filename=time().$i++.'.'.$extension;
                $image->move('uploads/products/',$filename);
                $filepath='uploads/products/'.$filename;

                $prodImage= new ProductImage;
                $prodImage->image=$filepath;
                $prodImage->product_id=$product->id;
                $prodImage->save();

            }

        }
       
        // if($request->hasFile('image')){

        //     $path='uploads/products/'.$product->image;
        //     if(File::exists($path)){
        //         File::delete($path);
        //     }
            
        //     $file = $request->file('image');
        //     $ext=$file->getClientOriginalExtension();
        //     $filename=time().'.'.$ext;

        //     $file->move('uploads/products/',$filename);
        //     $product->image= $filename;
            
        // }
        // $product->update();
 
        toast('Product updated sucessfully!','success');
        return redirect('admin/product');
        // ->with('message','Product Updated sucessfully!');
    }
    public function product_details($id){
        $categories = Category::all();
        $product = Products::find($id);
        $relatedProducts = Products::where('category_id', $product->category_id)->where('id', '!=', $id)->take(4)->get();

        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.details',compact('product','countcart','countorder','categories','relatedProducts'));
    }

    public function view_product(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        // Fetch products based on the selected category (default is "All")
        $selectedCategory = $request->query('category', 'All');

        if ($selectedCategory === 'All') {
            $product = Products::paginate(12);
        } else {
            $category = Category::where('name', $selectedCategory)->firstOrFail();
            $product = Products::where('category_id', $category->id)->paginate(12);
        }

        return view('home.product_page', compact('product', 'categories', 'selectedCategory','countcart','countorder'));
    }
    public function category_filter(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        // Fetch products based on the selected category (default is "All")
        $selectedCategory = $request->query('category', 'All');
        $category = Category::where('name', $selectedCategory)->firstOrFail();
        $product = Products::where('category_id', $category->id)->paginate(12);

        return view('home.category_filter', compact('product', 'categories', 'selectedCategory','countcart','countorder'));
    }

    public function search_products(Request $request)
    {
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        
        $query = $request->input('query');
        $productQuery = Products::query();
        
        if ($query) {
            $productQuery->where('name', 'LIKE', "%{$query}%");
        }
        
        $product = $productQuery->paginate(12);
        
        return view('home.category_filter', compact('product', 'categories', 'query', 'countcart', 'countorder'));
    }
  
}
