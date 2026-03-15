<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    
    public function login(){
        return view('auth.login');
    }

    public function login_post(LoginRequest $request){
        $credentials = $request->only('phone','password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }
        return back()->withErrors([
            'phone' => 'Telefon yoki parol noto‘g‘ri'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function error_403(){
        return view('auth.error_403');
    }

    public function error_404(){
        return view('auth.error_404');
    }

}
