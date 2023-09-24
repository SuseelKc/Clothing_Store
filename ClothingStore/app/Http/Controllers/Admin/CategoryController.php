<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories=Category::all();
        return view('admin.category.index',compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(CategoryFormRequest $request){

        $validatedData=$request->validated();

        $category = new Category;
        $category->name=$validatedData['name'];
        $category->slug=$validatedData['slug'];
        $category->description=$validatedData['description'];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/category/',$filename);
            $category->image= $filename;
            
        }
        $category->status=$request->status == true ? '1' :'0';
        $category->save();

        return redirect('admin/category')->with('message','Category Saved sucessfully!');
    }

    public function update(CategoryFormRequest $request,$id){

        $validatedData=$request->validated();

        $category= Category::findOrFail($id);
        $category->name=$validatedData['name'];
        $category->slug=$validatedData['slug'];
        $category->description=$validatedData['description'];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;

            $file->move('uploads/category/',$filename);
            $category->image= $filename;
            
        }
        $category->status=$request->status == true ? '1' :'0';
        $category->update();

        return redirect('admin/category')->with('message','Category updated sucessfully!');

    }
     
    public function edit($id){

       $category=Category::findOrFail($id);
       return view('admin.category.edit',compact('category'));
    }


    public function delete($id){
        $category=Category::findOrFail($id);
        $category->delete();
        return redirect('admin/category')->with('message','Category Deleted sucessfully!');
    }
}
