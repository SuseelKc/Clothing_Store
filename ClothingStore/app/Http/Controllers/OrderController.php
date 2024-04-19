<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Sizes;
use App\Models\Address;
use App\Models\Category;
use App\Models\Products;
use App\Enums\PaymentType;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Enums\DeliveryStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function cash_order(Request $request)
    {
       
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
        
        Mail::send('order_placed_gmail', [], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Thank You for Your Order');
        });

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


    public function userdashboard()
    {
        $userId = auth()->id();
        
        $categories = Category::all();

        $countcart = Cart::where('user_id', $userId)->count();

        $orders = OrderMaster::where('user_id', $userId);
        
        $countorder = $orders->count();
        $countcash = $orders->where('payment_type', PaymentType::CashOnDelivery)->count();
        $countPaypal = $orders->where('payment_type', PaymentType::Paypal)->count();

        $countCancelledOrders = $orders->where('delivery_status', DeliveryStatus::Cancelled)->count();

        $countProcessing = $orders->where('delivery_status', DeliveryStatus::Processing)->count();
        $countDelivered = $orders->where('delivery_status', DeliveryStatus::Delivered)->count();  
        
        //for displaying orders
        $user_id = auth()->user()->id;
        $orderMasters = OrderMaster::where('user_id', $user_id)->with('orders')->get();

        return view('home.userdashboard', compact('countcart', 'countorder', 'countCancelledOrders', 'categories', 'countProcessing', 'countDelivered', 'countPaypal', 'countcash', 'orderMasters'));
    }

    public function cancel_order($id)
    {
        $Order = OrderMaster::findOrFail($id);
    
        $orderIDs = Order::where('order_master_id', $id)->get();
    
        foreach ($orderIDs as $orderID) {
            $userId = Auth::user()->id;
            $prodID = $orderID->product_id;
            $product = Products::findOrFail($prodID);
            $addQty = $orderID->quantity;
            $productqty = $product->quantity;
            $product->quantity = $addQty + $productqty;
    
            // Check if the order has a size_id
            if (!is_null($orderID->size_id)) {
                $size = Sizes::findOrFail($orderID->size_id);
                $sizeName = $size->size;
                $product->$sizeName = $product->$sizeName + $addQty;
            }
    
            $product->update();
        }
    
        $Order->delivery_status = DeliveryStatus::Cancelled;
        $Order->update();
        return redirect()->back();
    }
    
    public function address()
    {
        $cart = Cart::where('user_id', auth()->id())->get();
        $totalAmount = $cart->sum('price'); 
        $khaltiAmount = $totalAmount * 100;
        $categories = Category::all();
        $countcart = Cart::where('user_id', auth()->id())->count();
        $countorder = OrderMaster::where('user_id', auth()->id())->count();
        return view('home.cart.address',compact('countcart','countorder','categories','totalAmount','khaltiAmount','cart'));
    }
    
    public function storeaddress(Request $request)
    {

        // ordered
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
        // 


        // 
        // $order_master->save();
        //for order data
        $data = Cart::where('user_id','=',$user_id)->get();
        
        foreach($data as $data)
        {
                        
            $order = new Order;
            $order->user_id = $data->user_id;
            $order->product_id = $data->product_id;
            $order->size_id=$data->size_id;
            
            // $order->order_master_id = $order_master->id;

            $product=Products::findOrfail($data->product_id);
            // dd($product);
            if(($product->quantity)<($data->quantity)||($product->quantity)<=0){
                // dd("here");
                // toast('Out Of stock Ordered!','danger');
                // return redirect()->back();
                return redirect('/cart')->with('danger','Out Of stock Ordered! Order less than '.$product->quantity );
            }
            $product->quantity=($product->quantity)-($data->quantity);

            //  size 
                if($data->size_id){
                
                    $size=Sizes::findOrFail($data->size_id);
                    $sizeName=$size->size;

                    if(($data->quantity)>($product->$sizeName)||($data->quantity)<=0){
                    
                        // toast('Out Of stock Ordered!','danger');
                        return redirect('/cart')->with('danger',$product->name.' '.$sizeName.' Size Out Of stock Ordered! Order less than'.$product->$sizeName );
                    }
                    $product->$sizeName=$product->$sizeName-($data->quantity);


                }
            // 
            $order_master->save();
            $order->order_master_id = $order_master->id;    

            // 
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

        //    

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
        
        $address = new Address;
        $user_id = Auth::user()->id;
        $address->user_id=$user_id;
        $address->street=$request->input('street');
        // dd($address->street);
        $address->state=$request->input('state');
        $address->city=$request->input('city');
        $address->country=$request->input('country');
        $address->contact_name=$request->input('contact_name');
        $address->contact_no=$request->input('contact_number');
        $address->address_name=$request->input('address_name');
        $address->type=$request->input('payment_type');
        $address->order_master_id=$order_master->id;
        // $address->order_id=$order->id;
        $address->save();

        Mail::send('order_placed_gmail', ['totalAmount' => $totalAmount], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Thank You for Your Order');
        });
    
        return Redirect::route('ordered');
        // Redirect back to the address form or any other page
        // return redirect()->route('cash_order');
    }
}
