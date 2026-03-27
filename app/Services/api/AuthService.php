<?php

namespace App\Services\api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthService{

    public function login(array $data){
        $user = User::where('phone', $data['phone'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Telefon raqami yoki parol noto‘g‘ri.'],
            ]);
        }
        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'phone' => ['Sizning hisobingiz faol emas.'],
            ]);
        }
        $user->sfmToken()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'token' => $data['SFMToken'],
                'device_type' => $data['device'],
            ]
        );
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function profile(){
        return Auth::user();
    }

    public function logout($user){
        $user->currentAccessToken()->delete();
        $user->sfmToken()->delete(); 
        return true;
    }

    public function changePassword($user, array $data){
        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Joriy parol noto‘g‘ri.'],
            ]);
        }
        $user->password = $data['new_password'];
        $user->save();
        return true;
    }
    

}