<?php

namespace App\Http\Requests\Web\Group;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendDebitSmsRequest extends FormRequest{

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'group_id' => 'required|exists:groups,id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
        ];
    }

    public function messages(): array{
        return [
            'student_ids.required' => 'Iltimos, SMS yuborish uchun kamida bitta talabani tanlang.',
            'student_ids.min' => 'Ro\'yxatdan kamida bitta talaba belgilanishi shart.',
            'group_id.required' => 'Guruh ma\'lumotlari topilmadi.',
        ];
    }
    
}
