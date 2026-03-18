<?php

namespace App\Http\Requests\web\kassa;

use App\Models\Kassa;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KassaChiqimRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:output_cash,output_card,cost_cash,cost_card',
            'description' => 'required|string|max:255',
        ];
    }
    protected function prepareForValidation(){
        $this->merge([
            'amount' => str_replace(' ', '', $this->amount),
        ]);
    }
    public function withValidator($validator){
        $validator->after(function ($validator) {
            $kassa = Kassa::first();
            if (!$kassa) {
                $validator->errors()->add('amount', 'Kassa topilmadi');
                return;
            }
            $amount = (float) $this->amount;
            if ($this->type === 'output_cash' && $amount > $kassa->cash) {
                $validator->errors()->add('amount', 'Kassada yetarli naqt mablag‘ yo‘q');
            }
            if ($this->type === 'output_card' && $amount > $kassa->card) {
                $validator->errors()->add('amount', 'Kassada yetarli karta mablag‘ yo‘q');
            }
        });
    }
}
