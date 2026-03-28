<?php

namespace App\Services\api;

use App\Jobs\SendSmsJob;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetService{

    public function sendOtp($phone){
        $user = User::where('phone', $phone)->first();
        if (!$user) {
            throw ValidationException::withMessages(['phone' => 'Foydalanuvchi topilmadi.']);
        }
        if (!$user->is_active) {
            throw ValidationException::withMessages(['phone' => 'Hisobingiz faol emas.']);
        }
        $code = rand(10000, 99999);
        DB::table('otp_codes')->updateOrInsert(
            ['phone' => $phone],
            ['code' => $code, 'expires_at' => now()->addMinutes(10)]
        );
        SendSmsJob::dispatch(str_replace('+', '', $user->phone),$user->name,"","$code",'verify');
        return $code;
    }
    
    public function verifyAndReset($phone, $code){
        $otp = DB::table('otp_codes')->where('phone', $phone)->where('code', $code)->where('expires_at', '>', now())->first();
        if (!$otp) {
            throw ValidationException::withMessages(['code' => 'Kod xato yoki muddati o‘tgan.']);
        }
        $newPassword = 'password';        
        $user = User::where('phone', $phone)->first();
        $user->password = $newPassword;
        $user->save();
        DB::table('otp_codes')->where('phone', $phone)->delete();
        SendSmsJob::dispatch(str_replace('+', '', $user->phone),$user->name,"","",'password');
        return $newPassword;
    }

}