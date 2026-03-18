<?php

namespace App\Http\Requests\Web\Visit;

use App\Models\GroupUser;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GroupUserStoreRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'user_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id',
            'start_comment' => 'required|string|max:1000',
        ];
    }
}
