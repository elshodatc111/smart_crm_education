<?php

namespace App\Http\Requests\Web\Visit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserPaymentStoreRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    protected function prepareForValidation(){
        $this->merge([
            'cash' => (float) str_replace([' ', ','], '', $this->cash),
            'card' => (float) str_replace([' ', ','], '', $this->card),
        ]);
    }
    public function rules(): array{
        return [
            'user_id' => 'required|exists:users,id',
            'cash' => 'required|numeric|min:0',
            'card' => 'required|numeric|min:0',
            'type' => 'required',
            'description' => 'nullable|string|max:500',
        ];
    }
    public function withValidator($validator)    {
        $validator->after(function ($validator) {
            $cash = (float) $this->cash;
            $card = (float) $this->card;
            if ($cash <= 0 && $card <= 0) {
                $validator->errors()->add(
                    'cash',
                    'Kamida bitta to‘lov (naqt yoki karta) 0 dan katta bo‘lishi kerak'
                );
            }
        });
    }
}
