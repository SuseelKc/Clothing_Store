<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Category;


class AuthenticatedSessionController extends Controller
{


    /**
     * Display the login view.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('auth.login',compact('categories'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
     
        $request->authenticate();

        $request->session()->regenerate();

        if(Auth::user()->usertype =='1'){
            
               toast('Welcome to Dashboard!','success');

                 return redirect('admin/dashboard');
                //  ->with('message','Welcome to Dashboard!');
            }
        else{
            return redirect('/dashboard')->with('message','Logged in sucessfully!');
        }        


    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    // public function authenticated(){
    //     if(Auth::user()->usertype =='1'){
    //         return redirect('admin/dashboard')->with('status','Welcome to Dashboard');
    //     }
    // }
  
}
