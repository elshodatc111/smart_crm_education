<?php

namespace App\Http\Requests\Web\Group;

use App\Models\DamOlishKuni;
use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    protected function prepareForValidation(){
        $this->merge([
            'teacher_pay' => str_replace([' ', ','], '', $this->teacher_pay),
            'teacher_bonus' => str_replace([' ', ','], '', $this->teacher_bonus),
        ]);
    }
    public function rules(): array{
        return [
            'group_name' => 'required|string|max:255',
            'cours_id' => 'required|exists:cours,id',
            'room_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:users,id',
            'payment_id' => 'required|exists:payment_settings,id',
            'lesson_count' => 'required|integer|min:1',
            'group_type' => 'required|in:toq,juft,all',
            'lesson_time' => 'required',
            'start_lesson' => 'required|date|after_or_equal:today',
            'teacher_pay' => 'required|numeric|min:0',
            'teacher_bonus' => 'required|numeric|min:0',
        ];
    }
    public function withValidator($validator){
        $validator->after(function ($validator) {
            $isHoliday = DamOlishKuni::whereDate('data', $this->start_lesson)->exists();
            if ($isHoliday) {
                $validator->errors()->add(
                    'start_lesson',
                    'Tanlangan sana dam olish kuniga to‘g‘ri keladi'
                );
            }
        });
    }
}
