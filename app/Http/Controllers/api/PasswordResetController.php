<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\api\PasswordResetService;
use Illuminate\Http\Request;

class PasswordResetController extends Controller{

    protected $service;
    public function __construct(PasswordResetService $service){
        $this->service = $service;
    }
    
    public function sendCode(Request $request){
        $request->validate(['phone' => 'required|string']);        
        $this->service->sendOtp($request->phone);
        return response()->json([
            'status' => 'success',
            'message' => 'Tasdiqlash kodi telefoningizga yuborildi.'
        ]);
    }
    
    public function verifyCode(Request $request){
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string|size:5'
        ]);
        $this->service->verifyAndReset($request->phone, $request->code);
        return response()->json([
            'status' => 'success',
            'message' => 'Telefon raqam tasdiqlandi. Yangi parol SMS orqali yuborildi.'
        ]);
    }
    
}
