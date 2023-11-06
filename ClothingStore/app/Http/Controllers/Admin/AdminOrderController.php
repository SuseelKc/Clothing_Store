<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Sizes;
use App\Models\Address;
use App\Models\Products;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Enums\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminOrderController extends Controller
{
    public function index(){
        $orders=OrderMaster::orderBy('created_at', 'desc')->get();
        // $order=$orders->id;
       
        // $address=  Address::which()    
        return view('admin.order.index',compact('orders'));
    }

    public function viewProducts($id){
       
        $products=Order::where('order_master_id',$id)->get();
        $orders=OrderMaster::findOrFail($id);
       
        $address=Address::where('order_master_id','=',$orders->id)->first();
        // dd($address->id);
        return view('admin.order.order',compact('products','orders','address'));
    }

    public function orderDelivered($id){

        $order=OrderMaster::findOrFail($id); 
        $order->delivery_status = DeliveryStatus::Delivered; 
        $order->save();
        
        toast('Order Delivered!','success');
        return redirect()->back();
    }

    public function orderCancelled($id){
        $order=OrderMaster::findOrFail($id);
        
        // 
        $orderID=Order::where('order_master_id',$id)->get()->toArray();
       
       
        foreach ($orderID as $orderID){
            $userId=Auth::user()->id;
            $prodID=Order::where('id','=',$orderID)->value('product_id');
            $product=Products::findOrFail($prodID);
            $addQty=$orderID['quantity'];
            $productqty=$product->quantity;
            $product->quantity= $addQty+ $productqty;

             // Check if the order has a size_id
             if (!is_null($orderID['size_id'])) {
                // $id=$orderID['size_id'];
                $size = Sizes::findOrFail($orderID['size_id']);
                $sizeName = $size->size;
                $product->$sizeName = $product->$sizeName + $addQty;
            }


            $product->update();
        }
        // 

      
        $order->delivery_status= DeliveryStatus::Cancelled; 

        $order->update();
        
        toast('Order cancelled!','success');
        return redirect()->back();
    }
    public function orderdelete($id){
        $ordermaster=OrderMaster::findOrFail($id);
        $order=Order::where('order_master_id',$id)->get();
       

        foreach ($order as $order) {
            $order->delete();
        }
       
        $address=Address::where('order_master_id',$ordermaster->id)->first();
        // dd($address);
        $address->delete();
        $ordermaster->delete();
        

        toast('Order deleted!','success');
        return redirect('admin/order');;

    }

}
