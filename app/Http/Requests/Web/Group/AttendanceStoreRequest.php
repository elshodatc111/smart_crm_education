<?php

namespace App\Http\Requests\Web\Group;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceStoreRequest extends FormRequest
{
    public function authorize(): bool{
        return true; 
    }

    public function rules(): array{
        return [
            'group_id' => 'required|exists:groups,id',
            'attendances' => 'required|array',
            'attendances.*.user_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:keldi,kelmadi,sababli',
        ];
    }

    public function messages(): array{
        return [
            'attendances.required' => 'Talabalar ro\'yxati topilmadi.',
            'attendances.*.status.in' => 'Noto\'g\'ri holat tanlandi.',
        ];
    }
}
