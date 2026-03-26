<?php

namespace App\Services\api;

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
        // SMS yuborish mantiqi (Sizning SMS provayderingiz)
        // SmsService::send($phone, "Tasdiqlash kodi: $code");
        return $code;
    }
    
    public function verifyAndReset($phone, $code){
        $otp = DB::table('otp_codes')->where('phone', $phone)->where('code', $code)->where('expires_at', '>', now())->first();
        if (!$otp) {
            throw ValidationException::withMessages(['code' => 'Kod xato yoki muddati o‘tgan.']);
        }
        $newPassword = Str::random(8);        
        $user = User::where('phone', $phone)->first();
        $user->password = $newPassword;
        $user->save();
        DB::table('otp_codes')->where('phone', $phone)->delete();
        // SMS orqali yangi parolni yuborish
        // SmsService::send($phone, "Sizning yangi parolingiz: $newPassword");
        return $newPassword;
    }

}