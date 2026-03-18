<?php

namespace App\Http\Requests\Web\Balans;

use App\Models\Balans;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExsonChiqimRequest extends FormRequest{
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
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'required|in:cash,card',
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
            if ($this->payment_type === 'cash') {
                if ($amount > $balans->cash_exson) {
                    $validator->errors()->add('amount', 'Exson (naqt) mablag‘i yetarli emas');
                }
            } elseif ($this->payment_type === 'card') {
                if ($amount > $balans->card_exson) {
                    $validator->errors()->add('amount', 'Exson (karta) mablag‘i yetarli emas');
                }
            }
        });
    }
}
