<?php

namespace App\Http\Controllers\api\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherPaymentController extends Controller{
    public function payments(){
        return response()->json([
            'status' => 'success',
            'data'   => "",
            'message' => 'Bu qismi tayyorlanmoqda(O\'qituvchi ish haqi to\'lovlari)'
        ]);
    }
}
