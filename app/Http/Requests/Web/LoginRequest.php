<?php

namespace App\Http\Requests\Web;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'phone' => [
                'required',
                'string',
                'regex:/^\+998\d{9}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20'
            ]
        ];
    }

    public function messages(): array{
        return [
            'phone.required' => 'Telefon raqam kiritilishi shart',
            'phone.regex' => 'Telefon raqam +998901234567 formatda bo‘lishi kerak',
            'password.required' => 'Parol kiritilishi shart',
            'password.min' => 'Parol kamida 8 ta belgidan iborat bo‘lishi kerak',
            'password.max' => 'Parol 20 ta belgidan oshmasligi kerak',
        ];
    }

    protected function prepareForValidation(){
        if ($this->phone) {
            $phone = preg_replace('/[\s_]/', '', $this->phone);
            $this->merge([
                'phone' => $phone
            ]);
        }
    }
    
}
