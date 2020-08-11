<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    
	public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        if (auth()->guard('users')->check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function signin(Request $Request){
        if (Auth::guard('users')->attempt(['username' => $Request->username, 'password' => $Request->password, 'flag_status' => 'Y' ])){
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->back()->with('status', 'Sorry not found your account and please check your password');
        }
    }

    public function logout(){
        auth()->guard('users')->logout();
        return redirect()->route('login');
    }
}
