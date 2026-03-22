<?php

namespace App\Http\Requests\Web\Visit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialPaymentRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    protected function prepareForValidation(){
        $this->merge([
            'cash' => str_replace([' ', "\xc2\xa0"], '', $this->cash ?? 0),
            'card' => str_replace([' ', "\xc2\xa0"], '', $this->card ?? 0),
        ]);
    }
    public function rules(): array{
        return [
            'user_id'     => 'required|integer|exists:users,id',
            'id'          => 'required|integer|exists:payment_specials,id',
            'cash'        => 'required|numeric|min:0',
            'card'        => 'required|numeric|min:0',
            'description' => 'required|string|min:3|max:1000',
        ];
    }
    public function withValidator($validator){
        $validator->after(function ($validator) {
            $cash = (float) $this->cash;
            $card = (float) $this->card;
            if ($cash <= 0 && $card <= 0) {
                $validator->errors()->add('cash', 'Naqd yoki karta orqali to\'lov kiritilishi shart!');
                $validator->errors()->add('card', 'Ikkala to\'lov turi ham 0 bo\'lishi mumkin emas.');
            }
        });
    }
    public function messages(): array{
        return [
            'id.required'         => 'Maxsus to\'lov turini tanlang.',
            'cash.numeric'        => 'Naqd pul summasi raqam bo\'lishi kerak.',
            'card.numeric'        => 'Karta pul summasi raqam bo\'lishi kerak.',
            'description.required' => 'To\'lov haqida izoh kiritish majburiy.',
        ];
    }
}
