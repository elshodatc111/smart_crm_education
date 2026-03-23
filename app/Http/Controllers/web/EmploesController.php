<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Emploes\StoreEmploesRequest;
use App\Http\Requests\Web\Emploes\UpdateUserRequest;
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
        $user = User::findOrFail($id);
        return view('emploes.emploes_show',compact('user'));
    }

    public function updatePassword(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->password = 'password';
        $user->save();
        return back()->with('success', 'Parol yangilandi!');
    }

    public function toggleStatus(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->is_active = !$user->is_active; 
        $user->save();
        return back()->with('success', 'Foydalanuvchi holati o‘zgartirildi!');
    }

    public function update(UpdateUserRequest $request){
        $user = User::findOrFail($request->user_id);
        $user->update([
            'name'       => $request->name,
            'birth_date' => $request->birth_date,
            'role'       => $request->role,
            'phone'      => $request->phone,
            'phone_alt'  => $request->phone_alt,
        ]);
        return redirect()->back()->with('success', 'Foydalanuvchi muvaffaqiyatli yangilandi!');
    }


}
