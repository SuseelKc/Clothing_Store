<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Enums\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AdminOrderController extends Controller
{
    public function index(){
        $orders=OrderMaster::orderBy('created_at', 'desc')->get();
        return view('admin.order.index',compact('orders'));
    }

    public function viewProducts($id){
       
        $products=Order::where('order_master_id',$id)->get();
        $orders=OrderMaster::findOrFail($id);

        return view('admin.order.order',compact('products','orders'));
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
      
        $order->delivery_status= DeliveryStatus::Cancelled; 

        $order->save();
        
        toast('Order cancelled!','success');
        return redirect()->back();
    }
    public function orderdelete($id){
        $ordermaster=OrderMaster::findOrFail($id);
        $order=Order::where('order_master_id',$id)->get();

        foreach ($order as $order) {
            $order->delete();
        }
        $ordermaster->delete();
        

        toast('Order deleted!','success');
        return redirect('admin/order');;

    }

}
