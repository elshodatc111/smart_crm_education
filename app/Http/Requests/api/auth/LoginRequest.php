<?php

namespace App\Http\Requests\api\auth;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'phone'    => ['required', 'string'],
            'password' => ['required', 'string', Password::min(8)],
            'SFMToken' => ['required', 'string', 'min:10'],
            'device' => ['required']
        ];
    }
    public function messages(): array{
        return [
            'phone.regex' => 'Telefon raqami noto‘g‘ri formatda.',
            'password.min' => 'Parol kamida 8 ta belgidan iborat bo‘lishi kerak.',
        ];
    }
}
