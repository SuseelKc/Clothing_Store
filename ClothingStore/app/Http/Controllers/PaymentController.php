<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Products;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Enums\PaymentType;
use App\Enums\DeliveryStatus;

class PaymentController extends Controller
{
    private $gateway;
    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }
    
    public function pay(Request $request)
    {
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $request->totalAmount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();
            // Create an Address
            $request->validate([
                'street' => 'required',
                'state' => 'required',
                'city' => 'required',
                'country' => 'required',
                'contact_name' => 'required',
                'contact_number' => 'required',
                'address_name' => 'required',
            ]);

            session([
                'street' => $request->input('street'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'contact_name' => $request->input('contact_name'),
                'contact_number' => $request->input('contact_number'),
                'address_name' => $request->input('address_name'),
                'payment_type' => $request->input('payment_type'),
            ]);

            if($response->isRedirect()){
                $response->redirect();
            }
            else{
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ]);
    
            $response = $transaction->send();
    
            if ($response->isSuccessful()) {
                $arr = $response->getData();
    
                // Create a Payment record
                $payment = new Payment();
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['state'];
                $payment->save();
    
                // Create an OrderMaster
                $orderMaster = new OrderMaster();
                $orderMaster->user_id = Auth::user()->id;
                $orderMaster->purchasecode = $this->PurchaseCode();
                $purchase_code = $this->PurchaseCode(); 
                session(['purchase_code' => $purchase_code]);
                $orderMaster->payment_type = PaymentType::Paypal;
                $orderMaster->totalamount = Auth::user()->cart->sum('price');
                $orderMaster->save();
    
                // Create Order items
                $user_id = Auth::user()->id;
                $cartItems = Cart::where('user_id', $user_id)->get();
    
                foreach ($cartItems as $cartItem) {
                    $order = new Order();
                    $order->user_id = $cartItem->user_id;
                    $order->product_id = $cartItem->product_id;
                    $order->size_id=$cartItem->size_id;
                    $order->order_master_id = $orderMaster->id;
    
                    $product = Products::findOrFail($cartItem->product_id);
    
                    if ($product->quantity < $cartItem->quantity || $product->quantity <= 0) {
                        toast('Out Of stock Ordered!', 'danger');
                        return redirect()->back();
                    }
    
                    $product->quantity -= $cartItem->quantity;
                    $product->update();
    
                    $order->quantity = $cartItem->quantity;
                    $order->rate = $cartItem->rate;
                    $order->amount = $cartItem->price;
                    $order->save();
    
                    // Delete the item from the cart
                    $cartItem->delete();
                }
    
                // Create an Address
    
                $address = new Address();
                $address->user_id = Auth::user()->id;
                $address->street = session('street');
                $address->state = session('state');
                $address->city = session('city');
                $address->country = session('country');
                $address->contact_name = session('contact_name');
                $address->contact_no = session('contact_number');
                $address->address_name = session('address_name');
                $address->type = session('payment_type');
                $address->order_master_id = $orderMaster->id;
                $address->save();
    
                return redirect()->route('ordered');
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Payment is declined!';
        }
    }
    
    public function error()
    {
        return 'User declined the payment!';
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
}
