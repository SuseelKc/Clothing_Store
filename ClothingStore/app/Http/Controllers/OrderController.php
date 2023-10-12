<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Products;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Enums\PaymentType;
use App\Enums\DeliveryStatus;
use App\Models\Category;

class OrderController extends Controller
{
    public function cash_order(Request $request)
    {
        dd("here");
        $user_id = Auth::user()->id;
        //order_master
        $order_master = new OrderMaster;
        $user = Auth::user();
        $order_master->user_id = $user->id;
        //for purchase code
        $order_master->purchasecode = $this->PurchaseCode(); 
        // storing purchase code in a variable to show in welcome blade
        $purchase_code = $this->PurchaseCode(); 
        session(['purchase_code' => $purchase_code]);

        $order_master->payment_type = PaymentType::CashOnDelivery;
        // $order_master->totalamount = $request->input('totalAmount');
        $totalAmount = $user->cart->sum('price');
    
        $order_master->totalamount = $totalAmount;
        $order_master->save();
        //for order data
        $data = Cart::where('user_id','=',$user_id)->get();

        foreach($data as $data)
        {
                        
            $order = new Order;
            $order->user_id = $data->user_id;
            $order->product_id = $data->product_id;
            
            $order->order_master_id = $order_master->id;

            $product=Products::findOrfail($data->product_id);
            // dd($product);
            if(($product->quantity)<=($data->quantity)||($product->quantity)<=0){
                toast('Out Of stock Ordered!','danger');
                return redirect()->back();
            }
            $product->quantity=($product->quantity)-($data->quantity);
            $product->update();

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
        dd("here");
        $categories = Category::all();
        $purchase_code = session('purchase_code'); 
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.thankyou',compact('purchase_code','countcart','countorder','categories'));
    }
 
    public function showOrders()
    {
        $categories = Category::all();
        $user_id = auth()->user()->id;
        $orderMasters = OrderMaster::where('user_id', $user_id)->with('orders')->orderBy('created_at', 'desc')->get();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();

        return view('home.vieworders', compact('orderMasters','countcart','countorder','categories'));
    }

   
    public function cancel_order($id)
    { 
       
        $Order=OrderMaster::findOrFail($id);
       
        $orderID=Order::where('order_master_id',$id)->get()->toArray();
       
       
        foreach ($orderID as $orderID){
            $userId=Auth::user()->id;
            $prodID=Order::where('id','=',$orderID)->value('product_id');
            $product=Products::findOrFail($prodID);
            $addQty=$orderID['quantity'];
            $productqty=$product->quantity;
            $product->quantity= $addQty+ $productqty;
            $product->update();
        }

        $Order->delivery_status = DeliveryStatus::Cancelled;
        $Order->update();
        return redirect()->back();
    }
    public function address()
    {
        // dd("Her");
        $cart = Cart::where('user_id', auth()->id())->get();
        $totalAmount = $cart->sum('price'); 
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.cart.address',compact('countcart','countorder','categories','totalAmount','cart'));
    }
    
    public function storeaddress(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'street' => 'required',
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            'contact_name' => 'required',
            'contact_number' => 'required',
            'address_name' => 'required',
        ]);

        // Create a new Address record
        Address::create([
            'user_id' => auth()->id(), // Assuming you're using user authentication
            'street' => $request->input('street'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'contact_name' => $request->input('contact_name'),
            'contact_no' => $request->input('contact_number'),
            'address_name' => $request->input('address_name'),
            'type' => $request->input('payment_type'),
        ]);

        // Redirect back to the address form or any other page
        return redirect()->route('cash_order');
    }
}
