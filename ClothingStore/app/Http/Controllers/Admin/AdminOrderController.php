<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrderController extends Controller
{
    public function index(){
        $orders=OrderMaster::all();
        return view('admin.order.index',compact('orders'));
    }

    public function viewProducts($id){
       
        $products=Order::where('order_master_id',$id)->get();
        // dd($products);

        return view('admin.order.order',compact('products'));
    }

    public function orderDelivered($id){
        $order=OrderMaster::findOrFail($id);
        dd($order);

    }

    public function orderCancelled($id){
        $order=OrderMaster::findOrFail($id);
        dd($order);
    }

}
