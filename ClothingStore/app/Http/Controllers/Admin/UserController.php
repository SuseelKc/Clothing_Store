<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index(){
        $user=User::where('usertype', 0)->get();
        return view('admin.user.index',compact('user'));
    }

    public function edit($id){
        
        $user=User::findOrFail($id);
     
        return view('admin.user.edit',compact('user'));
    }

    public function update(Request $request,$id){

        $user=User::findOrFail($id);
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->address=$request->input('address');
        $user->contact=$request->input('contact');
        $user->save();
        toast('User Updated!','success');  
        return redirect('/admin/userview');

    }
    public function delete($id){
       $user=User::findOrFail($id);
       // Delete associated addresses
        Address::where('user_id', $id)->delete();
        
        // Delete associated carts
        Cart::where('user_id', $id)->delete();

        // Delete associated orders
        Order::where('user_id', $id)->delete();

        // Delete associated ordermasters
        OrderMaster::where('user_id', $id)->delete();

       $user->delete();
       toast('User Deleted!','success');   
       return redirect('/admin/userview');

    }
    
}
