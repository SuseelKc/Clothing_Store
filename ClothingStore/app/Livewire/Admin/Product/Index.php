<?php

namespace App\Livewire\Admin\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Products;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

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
        try{
        

            $product=Products::findOrFail($this->prod_id);

            $product->delete();
            
            $prodImg=ProductImage::where('product_id',$this->prod_id)->get();
            
            foreach ($prodImg as $prodImg) {
                $imagepath = $prodImg->image;
                File::delete($imagepath);
               
            }                        
            ProductImage::where('product_id',$this->prod_id)->delete();              
            Cart::where('product_id',$this->prod_id)->delete();
            toast('Product Deleted!','info');

        }catch (QueryException $e){
            toast("can't delete used in order or added to cart!",'error');
        }

        return redirect('admin/product');
        // ->with('message','Product deleted successfully!');


    }
}
