<?php

namespace App\Http\Requests\Web\Balans;

use App\Models\Balans;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BalansChiqimRequest extends FormRequest{
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
            'category' => 'required|in:xarajat,daromad',
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
            if ($this->payment_type === 'cash' && $amount > $balans->cash) {
                $validator->errors()->add('amount', 'Balansda yetarli naqt mablag‘ yo‘q');
            }
            if ($this->payment_type === 'card' && $amount > $balans->card) {
                $validator->errors()->add('amount', 'Balansda yetarli karta mablag‘ yo‘q');
            }
        });
    }
}
