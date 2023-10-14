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
        // dd($user);
        return view('admin.user.edit',compact('user'));
    }
}
