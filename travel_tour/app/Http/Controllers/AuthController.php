<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // login
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();

            if($user->status == 'blocked'){
                Auth::logout();
                return back()->with('error','Tài khoản bị khóa');
            }

            if($user->role == 'admin'){
                return redirect()->route('admin.dashboard');
            }

            if($user->role == 'guide'){
                return redirect()->route('guide.dashboard');
            }

            return redirect()->route('home');
        }

        return back()->with('error','Email hoặc mật khẩu sai');
    }

    // form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // register
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'role'=>'user'
        ]);

        return redirect()->route('login')->with('success','Đăng ký thành công');
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}