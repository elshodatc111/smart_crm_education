<?php

namespace App\Http\Requests\Web\Visit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequest extends FormRequest{

    public function authorize(): bool{
        return true;
    }
    protected function prepareForValidation(){
        $this->merge([
            'phone' => preg_replace('/\s+/', '', $this->phone),
            'phone_alt' => preg_replace('/\s+/', '', $this->phone_alt),
        ]);
    }
    public function rules(): array{
        return [
            'name' => 'required|string|max:255',
            'phone' => ['required','regex:/^\+998\d{9}$/','unique:users,phone'],
            'phone_alt' => ['required','regex:/^\+998\d{9}$/'],
            'birth_date' => 'required|date',
            'address' => 'required',
        ];
    }
    public function messages(): array{
        return [
            'phone.users' => 'Telefon raqam oldin ro\'yhatga olingan',
            'phone.regex' => 'Telefon noto‘g‘ri formatda (+998901234567)',
            'phone_alt.regex' => 'Qo‘shimcha telefon noto‘g‘ri formatda',
            'address.required' => 'Hududni tanlang',
        ];
    }
}
