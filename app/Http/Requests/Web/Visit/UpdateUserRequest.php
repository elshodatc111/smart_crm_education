<?php

namespace App\Http\Requests\Web\Visit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool{
        return true;
    }

    protected function prepareForValidation(){
        $this->merge([
            'phone_alt' => preg_replace('/\s+/', '', $this->phone_alt),
        ]);
    }

    public function rules(): array{
        return [
            'name' => 'required|string|max:255',
            'phone_alt' => ['required','regex:/^\+998\d{9}$/'],
            'address' => 'required',
            'birth_date' => 'required|date',
        ];
    }

    public function messages(): array{
        return [
            'phone_alt.regex' => 'Telefon formati noto‘g‘ri (+998901234567)',
        ];
    }
}
