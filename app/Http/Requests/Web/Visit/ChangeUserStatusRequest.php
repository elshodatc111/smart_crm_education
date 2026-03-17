<?php

namespace App\Http\Requests\Web\Visit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangeUserStatusRequest extends FormRequest{

    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
    
}
