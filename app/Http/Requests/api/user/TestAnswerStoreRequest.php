<?php

namespace App\Http\Requests\api\user;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TestAnswerStoreRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'group_id' => 'required|exists:groups,id',
            'cours_id' => 'required|exists:cours,id',
            'savollar'  => 'required',
            'togri_javob'  => 'required',
            'ball'  => 'required',
        ];
    }
}
