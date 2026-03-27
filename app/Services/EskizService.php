<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class EskizService{

    protected string $baseUrl = 'https://notify.eskiz.uz/api';
    
    public function getToken(): ?string{
        return Cache::remember('eskiz_auth_token', 86400, function () {
            $response = Http::post("{$this->baseUrl}/auth/login", [
                'email'    => env('ESKIZ_EMAIL'),
                'password' => env('ESKIZ_PASSWORD'),
            ]);
            if ($response->successful()) {
                return $response->json('data.token');
            }
            Log::error('Eskiz Auth Error: ' . $response->body());
            return null;
        });
    }
    
    public function sendSms(string $phone, string $message): array{
        $token = $this->getToken();
        if (!$token) {
            return ['status' => 'error', 'message' => 'Token topilmadi'];
        }
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        $response = Http::withToken($token)->post("{$this->baseUrl}/message/sms/send", [
            'mobile_phone' => $cleanPhone,
            'message'      => $message,
            'from'         => '4545',
            'callback_url' => '',
        ]);
        return $response->json();
    }

}