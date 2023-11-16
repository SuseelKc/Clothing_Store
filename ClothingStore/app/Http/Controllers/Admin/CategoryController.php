<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Database\QueryException; 

class CategoryController extends Controller
{
    //
    public function index(){
        $categories=Category::simplePaginate(5);
        return view('admin.category.index',compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(CategoryFormRequest $request){

        $validatedData=$request->validated();

        if(Category::where('name',$validatedData['name'])->exists()){
            toast('Category exists!','error');  
            return back();

        }

        $category = new Category;
        $category->name=$validatedData['name'];
        $category->slug=$validatedData['slug'];
        $category->description=$validatedData['description'];
        $category->status=$request->status == true ? '1' :'0';

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/category/',$filename);
            $category->image= $filename;
            
        }
     
        $category->save();

        toast('Category Saved sucessfully!','success');
        return redirect('admin/category');
        // ->with('message','Category Saved sucessfully!');
    }

    public function update(CategoryFormRequest $request,$id){

        $validatedData=$request->validated();

        $category= Category::findOrFail($id);

        
        if($category->name !== $validatedData['name'] &&Category::where('name',$validatedData['name'])->exists()){
            toast('Category exists!','error');  
            return back();

        }

        $category->name=$validatedData['name'];
        $category->slug=$validatedData['slug'];
        $category->description=$validatedData['description'];
        

         if ($request->hasFile('image')) {

            $path='uploads/category/'.$category->image;
            if(File::exists($path)){
                File::delete($path);
            }
          
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/category/',$filename);
            $category->image= $filename;
            
        }
        $category->status=$request->status == true ? '1' :'0';
        $category->update();

        toast('Category Updated sucessfully!','success');

        return redirect('admin/category');
        // ->with('message','Category updated sucessfully!');

    } 
     
    public function edit($id){

       $category=Category::findOrFail($id);
       return view('admin.category.edit',compact('category'));
    }


    public function delete($id){
        try{
            $category=Category::findOrFail($id);
            $category->delete();
            $path='uploads/category/'.$category->image;
            if(File::exists($path)){
                File::delete($path);
            }
            
            toast('Category Deleted!','info');
        }catch(QueryException $e){
            toast('Cannot delete the category, it is used by products.', 'error');
        }
        
        return redirect('admin/category');
        // ->with('message','Category Deleted sucessfully!');
    }
}
