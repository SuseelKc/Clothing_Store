<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Sizes;
use App\Models\Category;
use App\Models\Products;
use App\Models\OrderMaster;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
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

        // sizes 
        $product->small=$request->input('small');
        $product->medium=$request->input('medium');
        $product->large=$request->input('large');
        $product->xl=$request->input('xl');
        $product->xxl=$request->input('xxl');

        $product->category_id=$request->category;
        $product->save();
        // size
       
        
        $selectedSizes = $request->input('size');
        if($selectedSizes){
        foreach($selectedSizes as $selectedSize){

            $size =new Sizes;
            $size->size=$selectedSize;
            $size->product_id=$product->id;
            $size->save();

        }
        }
        // 

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
    try {

        $validatedData= $request->validated();

        $product = Products::findOrFail($id);

        // 
        if(($product->name !== $validatedData['name']) && Products::where('name', $validatedData['name'])->exists()){
            toast('Product exists!','error');  
            return back();
        }
        // 

          // 
          $selectedSizes = $request->input('size');
          //    
       $allSizes=['small','medium','large','xl','xxl'];

       $uncheckedSizes=[];
       
       if(is_array($selectedSizes)){  

            $uncheckedSizes=array_diff($allSizes,$selectedSizes); 
            foreach($uncheckedSizes as $uncheckedSize){
            if(Sizes::where('product_id',$id)->where('size',$uncheckedSize)->first()){
                Sizes::where('product_id',$id)->where('size',$uncheckedSize)->first()->delete();
            }
            }
        }
       if($selectedSizes === null){

            if(Sizes::where('product_id',$id)->get()){
                Sizes::where('product_id',$id)->delete();
            }
       }         
     // 
    
        if($selectedSizes){
            foreach($selectedSizes as $selectedSize){

                $size = Sizes::where('product_id',$id)->where('size',$selectedSize)->first(); 
                if($size){             
                    $size->size=$selectedSize;
                    $size->product_id=$product->id;
                    $size->update();
                }
                else{

                    $newSize= new Sizes;
                    $newSize->size=$selectedSize;
                    $newSize->product_id=$product->id;
                    $newSize->save();

                }

            }
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
        // size
        $product->small=$request->input('small');
        $product->medium=$request->input('medium');
        $product->large=$request->input('large');
        $product->xl=$request->input('xl');
        $product->xxl=$request->input('xxl');
        // 

        $product->update();

         
        if($request->hasfile('image')){


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
 
        toast('Product updated sucessfully!','success');
        return back();
    } catch (QueryException $e) {
        // Handle database exception (e.g., foreign key constraint violation)
        toast('Error updating product sizes in order already exists !', 'error');
        return back();
    } 
       
    }
    public function product_details($id){
        $categories = Category::all(); // select * from categories;
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
    public function delImg($id){

        $prodImage=ProductImage::findOrFail($id);
        $ImagePath=$prodImage->image;
        File::delete($ImagePath); 
        $prodImage->delete();
        toast('Image Deleted!','success');
        return back();

      

    }
  
  
}
