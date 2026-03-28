<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\EmplesPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller{

    public function profile(){
        $payment = EmplesPayment::where('user_id',Auth::id())->orderby('id','desc')->get();
        $user = User::find(Auth::id());
        return view('profile.index',compact('payment','user'));
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required', 
                'confirmed',
            ],
        ], [
            'current_password.current_password' => 'Joriy parol noto‘g‘ri kiritildi.',
            'password.confirmed' => 'Yangi parollar bir-biriga mos kelmadi.',
        ]);
        $user = $request->user();
        $user->update([
            'password' => $request->password,
        ]);
        return back()->with('success', 'Parolingiz muvaffaqiyatli o‘zgartirildi!');
    }
}
