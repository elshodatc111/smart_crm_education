<?php

namespace App\Http\Requests\Web\Emploes;

use Illuminate\Foundation\Http\FormRequest;
class StoreEmploesRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    protected function prepareForValidation(){
        $this->merge([
            'phone' => preg_replace('/\s+/', '', $this->phone),
            'phone_alt' => preg_replace('/\s+/', '', $this->phone_alt),
            'balance' => preg_replace('/[^0-9]/', '', $this->balance),
        ]);
    }
    public function rules(): array{
        return [
            'name' => 'required|string|max:255',
            'role' => 'required',
            'phone' => ['required','regex:/^\+998\d{9}$/','unique:users,phone'],
            'phone_alt' => ['required','regex:/^\+998\d{9}$/'],
            'balance' => 'required|numeric|min:0',
            'birth_date' => 'required|date',
            'address' => 'required|string',
        ];
    }
    public function messages(): array{
        return [
            'phone.unique' => 'Bu telefon raqam allaqachon mavjud',
            'phone.regex' => 'Telefon formati noto‘g‘ri (+998901234567)',
            'phone_alt.regex' => 'Qo‘shimcha telefon formati noto‘g‘ri',
        ];
    }
}
