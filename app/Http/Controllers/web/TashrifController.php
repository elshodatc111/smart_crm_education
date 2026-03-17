<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Visit\StoreVisitRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TashrifController extends Controller{
    public function tashriflar(){
        $users = User::where('role','user')->orderby('id','desc')->get();
        return view('tashrif.tashriflar',compact('users'));
    }
    public function store(StoreVisitRequest $request){
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'phone_alt' => $request->phone_alt,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'password' => 'password',
            'role' => 'user',
            'is_active' => true,
            'balance' => 0,
            'created_by' => Auth::id(),
        ]);
        return back()->with('success','Tashrif muvaffaqiyatli qo‘shildi');
    }
    public function tashrifShow($id){
        return view('tashrif.tashrif_show');
    }
}
