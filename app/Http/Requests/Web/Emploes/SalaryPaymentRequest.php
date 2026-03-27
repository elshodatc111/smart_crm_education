<?php

namespace App\Http\Requests\Web\Emploes;

use App\Models\Balans;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SalaryPaymentRequest extends FormRequest{
    
    public function authorize(): bool{
        return true;
    }

    protected function prepareForValidation(): void{
        if ($this->has('amount')) {
            $this->merge(['amount' => str_replace([' ', ','], '', $this->amount),]);
        }
    }

    public function rules(): array{
        return [
            'group_id' => [
                'nullable',
                'integer'
            ],
            'user_id',
            'amount' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    $paymentType = $this->input('payment_type');
                    $balances = Balans::first();
                    if ($paymentType === 'cash' && $value > ($balances['cash_salary'] ?? 0)) {
                        $fail("Naqt balansda mablag' yetarli emas.");
                    }
                    if ($paymentType === 'card' && $value > ($balances['card_salary'] ?? 0)) {
                        $fail("Karta balansida mablag' yetarli emas.");
                    }
                },
            ],
            'payment_type' => ['required'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array{
        return [
            'amount.required' => 'To\'lov summasini kiriting.',
            'amount.numeric' => 'To\'lov summasi raqam bo\'lishi kerak.',
            'payment_type.required' => 'To\'lov turini tanlang.',
            'group_id.required_if' => 'O\'qituvchi uchun guruhni tanlash majburiy.',
        ];
    }
    
}
