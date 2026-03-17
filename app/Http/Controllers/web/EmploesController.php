<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Emploes\StoreEmploesRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmploesController extends Controller{
    
    public function emploes(){
        $users = User::where('role','!=','admin')->where('role','!=','user')->get();
        return view('emploes.emploes',compact('users'));
    }

    public function store(StoreEmploesRequest $request){
        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'phone' => $request->phone,
            'phone_alt' => $request->phone_alt,
            'balance' => $request->balance,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'created_by' => Auth::id(),
            'password' => 'password'
        ]);
        return back()->with('success', 'Hodim muvaffaqiyatli qo‘shildi');
    }

    public function emploesShow($id){
        return view('emploes.emploes_show');
    }


}
