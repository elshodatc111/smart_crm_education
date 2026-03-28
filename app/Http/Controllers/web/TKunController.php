<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class TKunController extends Controller{
    
    public function tkun(){
        $today = Carbon::today();
        $users = User::whereMonth('birth_date', $today->month)->whereDay('birth_date', $today->day)->get(['id', 'name', 'role', 'is_active', 'phone', 'birth_date']); 
        return view('tkun.index', compact('users'));
    }

}
