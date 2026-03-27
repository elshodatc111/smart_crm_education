<?php

namespace App\Http\Controllers\api\teacher;

use App\Http\Controllers\Controller;
use App\Models\EmplesPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherPaymentController extends Controller{

    public function payments(){
        $payment = EmplesPayment::where('user_id',Auth::id())->get();
        $res = [];
        foreach ($payment as $key => $value) {
           $res[$key]['id'] = $value->id;
           $res[$key]['group_name'] = $value->group_id?$value->group->group_name:"---";
           $res[$key]['amount'] = (int) $value->amount;
           $res[$key]['payment_type'] = $value->payment_type;
           $res[$key]['created_at'] = $value->created_at->format("Y-m-d h:i");
        }
        return response()->json([
            'status' => 'success',
            'data'   => $res,
        ]);
    }

}
