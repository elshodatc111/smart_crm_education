<?php

namespace App\Http\Requests\Web\Group;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupContinueRequest extends FormRequest{

    public function authorize(): bool {
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
            'group_id'      => 'required|exists:groups,id',
            'group_name'    => 'required|string|max:255',
            'cours_id'      => 'required|exists:cours,id',
            'room_id'       => 'required|exists:classrooms,id',
            'payment_id'    => 'required|exists:payment_settings,id',
            'teacher_id'    => 'required|exists:users,id',
            'teacher_pay'   => 'required|numeric|min:0',
            'teacher_bonus' => 'required|numeric|min:0',
            'group_type'    => 'required|in:toq,juft,all',
            'lesson_count'  => 'required|integer|min:1',
            'start_lesson'  => 'required|date',
            'lesson_time'   => 'required|string',
            'student_ids'   => 'nullable|array',
            'student_ids.*' => 'exists:users,id',
        ];
    }

}
