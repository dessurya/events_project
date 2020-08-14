<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\HistoryUserLogin;

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
            return redirect()->route('panel.dashboard');
        }
        return view('panel.login');
    }

    public function signin(Request $Request){
        if (Auth::guard('users')->attempt(['username' => $Request->username, 'password' => $Request->password, 'flag_status' => 'Y' ])){
            $this->recordINOUT('in', $Request->ip());
            return redirect()->route('panel.dashboard');
        }
        else{
            return redirect()->back()->with('status', 'Sorry not found your account and please check your password');
        }
    }

    public function logout(Request $Request){
        $this->recordINOUT('out', $Request->ip());
        auth()->guard('users')->logout();
        return redirect()->route('panel.login');
    }

    public function redirectLogin()
    {
        return redirect()->route('panel.login');
    }

    private function recordINOUT($type,$ip)
    {
        $save = Auth::guard('users')->user();
        HistoryUserLogin::create([
            'username' => $save->username,
            'name' => $save->name,
            'email' => $save->email,
            'type' => $type,
            'ip' => $ip
        ]);
    }
}
