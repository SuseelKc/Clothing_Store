<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index(){
        $user=User::all();
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
    
}
