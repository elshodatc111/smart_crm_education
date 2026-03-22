<?php

namespace App\Http\Requests\Web\Visit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest{

    public function authorize(): bool{
        return true; 
    }

    protected function prepareForValidation(){
        $this->merge([
            'teacher_pay' => str_replace([' ', "\xc2\xa0"], '', $this->teacher_pay),
            'teacher_bonus' => str_replace([' ', "\xc2\xa0"], '', $this->teacher_bonus),
        ]);
    }

    public function rules(): array{
        return [
            'group_id'      => 'required|integer|exists:groups,id',
            'group_name'    => 'required|string|max:255',
            'teacher_id'    => 'required|integer|exists:users,id',
            'cours_id'      => 'required|integer|exists:cours,id',
            'room_id'       => 'required|integer|exists:classrooms,id',
            'teacher_pay'   => 'required|numeric|min:0',
            'teacher_bonus' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array{
        return [
            'group_id.exists'      => 'Tahrirlanayotgan guruh bazada topilmadi.',
            'teacher_id.exists'    => 'Tanlangan o\'qituvchi tizimda mavjud emas.',
            'cours_id.exists'      => 'Tanlangan kurs mavjud emas.',
            'room_id.exists'       => 'Tanlangan dars xonasi mavjud emas.',
            'teacher_pay.numeric'  => 'O\'qituvchi haqi raqam bo\'lishi kerak.',
            'teacher_bonus.numeric' => 'Bonus miqdori raqam bo\'lishi kerak.',
        ];
    }
    
}
