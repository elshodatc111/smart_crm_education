<?php

namespace App\Http\Requests\Web\Group;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RemoveStudentRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    protected function prepareForValidation(){
        $this->merge([
            'jarima' => str_replace([' ', ','], '', $this->jarima),
            'maxJarima' => str_replace([' ', ','], '', $this->maxJarima),
        ]);
    }
    public function rules(): array{
        return [
            'group_id' => ['required', 'integer', 'exists:groups,id'],
            'user_id' => ['required', 'exists:users,id'],
            'maxJarima' => ['required', 'numeric', 'min:0'],
            'jarima' => [
                'required',
                'numeric',
                'min:0',
                'max:' . ($this->maxJarima ?? 0),
            ],
            'description' => ['required', 'string'],
        ];
    }
    public function messages(): array{
        return [
            'user_id.required' => 'O\'chirilishi kerak bo\'lgan talabani tanlang.',
            'jarima.max' => 'Jarima summasi ruxsat etilgan miqdordan (:max UZS) oshmasligi kerak.',
            'description.min' => 'Sabab kamida 10 ta belgidan iborat bo\'lishi lozim.',
        ];
    }

}
