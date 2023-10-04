<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Products;
use App\Models\Order;
use App\Models\OrderMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Enums\PaymentType;

class OrderController extends Controller
{
    public function cash_order(Request $request)
    {
        
        $user_id = Auth::user()->id;
        //order_master
        $order_master = new OrderMaster;
        $order_master->user_id = $user_id;
        //for purchase code
        $order_master->purchasecode = $this->PurchaseCode(); 
        // storing purchase code in a variable to show in welcome blade
        $purchase_code = $this->PurchaseCode(); 
        session(['purchase_code' => $purchase_code]);

        $order_master->payment_type = PaymentType::CashOnDelivery;
        $order_master->totalamount = $request->input('totalAmount');
        $order_master->save();
        //for order data
        $data = Cart::where('user_id','=',$user_id)->get();
        foreach($data as $data)
        {
            $order = new Order;
            $order->user_id = $data->user_id;
            $order->product_id = $data->product_id;
            $order->order_master_id = $order_master->id;
            $order->quantity = $data->quantity;
            $order->rate = $data->rate;
            $order->amount = $data->price;
            $order->save();

            //for deleting same data in cart
            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();
        }
        
        return Redirect::route('ordered');
    }
    private function PurchaseCode()
    {
        $latestPurchaseMaster = OrderMaster::latest('id')->first();
        if ($latestPurchaseMaster) {
            $lastCode = $latestPurchaseMaster->purchasecode;
            $parts = explode('-', $lastCode);
            $lastNumber = (int)end($parts);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $newCode = $parts[0] . '-' . $newNumber;
        } else {
            $newCode = 'PU-001'; // Initial code if no previous records exist
        }
        return $newCode;
    }
    public function ordered()
    {
        $purchase_code = session('purchase_code'); 
        return view('home.thankyou',compact('purchase_code'));
    }
    public function showOrders()
    {
        $user_id = auth()->user()->id;
        $order = OrderMaster::where('user_id', $user_id)->get();

        return view('home.vieworders', compact('order'));
    }

}
