<?php

namespace App\Http\Requests\Web\Visit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminDiscountRequest extends FormRequest{

    public function authorize(): bool{
        return true; 
    }
    protected function prepareForValidation(){
        if ($this->has('discount')) {
            $this->merge([
                'discount' => str_replace(' ', '', $this->discount),
            ]);
        }
    }
    public function rules(): array{
        return [
            'user_id'     => 'required|integer|exists:users,id',
            'group_id'    => 'required|integer', 
            'discount'    => 'required|numeric|min:0',
            'description' => 'required|string|min:5|max:1000',
        ];
    }
    public function messages(): array{
        return [
            'user_id.exists'      => 'Tanlangan talaba tizimda mavjud emas.',
            'group_id.required'   => 'Iltimos, chegirma guruhini tanlang.',
            'discount.required'   => 'Chegirma summasini kiritish majburiy.',
            'discount.numeric'    => 'Chegirma summasi faqat raqamlardan iborat bo\'lishi kerak.',
            'description.required' => 'Chegirma haqida izoh qoldirishingiz shart.',
        ];
    }
}
