<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    // public function index(){
    //     $categories = Category::all();
    //     $product = Products::paginate(8);
    //     $countcart = Cart::where('user_id', auth()->id())->count();
    //     $countorder = OrderMaster::where('user_id', auth()->id())->count();
    //     return view('home.userpage',compact('product','countcart','countorder','categories'));
    // }
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        // Fetch products based on the selected category (default is "All")
        $selectedCategory = request()->query('category', 'All');

        if ($selectedCategory === 'All') {
            $product = Products::paginate(12);
        } else {
            $product = Products::where('category_id', $category->id)->paginate(12);
        }

        return view('home.userpage', compact('product', 'categories', 'selectedCategory','countcart','countorder'));
    }
}
