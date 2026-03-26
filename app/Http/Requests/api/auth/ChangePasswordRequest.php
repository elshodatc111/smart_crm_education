<?php

namespace App\Http\Requests\api\auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest{

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'string', \Illuminate\Validation\Rules\Password::min(8), 'confirmed'],
        ];
    }

    public function messages(): array{
        return [
            'new_password.confirmed' => 'Yangi parollar bir-biriga mos kelmadi.',
            'new_password.min'       => 'Yangi parol kamida 8 ta belgidan iborat bo‘lishi kerak.',
        ];
    }
    
}
