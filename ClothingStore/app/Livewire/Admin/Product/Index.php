<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\File;

class Index extends Component
{

    public $prod_id;

    public function render()
    {
        $products=Products::simplePaginate(5);
        return view('livewire.admin.product.index',compact('products'));
    }
    public function  deleteProduct($id){
            
        $this->prod_id=$id;
    
    }

    public function destroyProduct(){

        $product=Products::findOrFail($this->prod_id);


        $path='uploads/products/'.$product->image;
            if(File::exists($path)){
                File::delete($path);
            }
        $product->delete();
        toast('Product Deleted!','info');
        return redirect('admin/product');
        // ->with('message','Product deleted successfully!');


    }
}
