<?php

namespace App\Http\Requests\Web\Balans;

use App\Models\Balans;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BalansConvertRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    protected function prepareForValidation(){
        $this->merge([
            'amount' => str_replace([' ', ','], '', $this->amount),
        ]);
    }
    public function rules(): array{
        return [
            'transfer_type' => 'required|in:balans_to_ishhaqi,ishhaqi_to_balans',
            'payment_type' => 'required|in:cash,card',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
        ];
    }
    public function withValidator($validator){
        $validator->after(function ($validator) {
            $balans = Balans::getBalans();
            if (!$balans) {
                $validator->errors()->add('amount', 'Balans topilmadi');
                return;
            }
            $amount = (float) $this->amount;
            if ($this->transfer_type === 'balans_to_ishhaqi') {
                if ($this->payment_type === 'cash' && $amount > $balans->cash) {
                    $validator->errors()->add('amount', 'Balansda yetarli naqt mablag‘ yo‘q');
                }
                if ($this->payment_type === 'card' && $amount > $balans->card) {
                    $validator->errors()->add('amount', 'Balansda yetarli karta mablag‘ yo‘q');
                }
            }
            if ($this->transfer_type === 'ishhaqi_to_balans') {
                if ($this->payment_type === 'cash' && $amount > $balans->cash_salary) {
                    $validator->errors()->add('amount', 'Ish haqi (naqt) yetarli emas');
                }
                if ($this->payment_type === 'card' && $amount > $balans->card_salary) {
                    $validator->errors()->add('amount', 'Ish haqi (karta) yetarli emas');
                }
            }
        });
    }
}
