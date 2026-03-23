<?php

namespace App\Http\Requests\Web\Emploes;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest{
    public function authorize(){
        return true;
    }
    public function rules(){
        return [
            'user_id'    => 'required|exists:users,id',
            'name'       => 'required|string|max:255',
            'birth_date' => 'required|date',
            'role'       => 'required|in:director,teacher,manager,operator,hodim',
            'phone'      => 'required|string|max:20',
            'phone_alt'  => 'nullable|string|max:20',
        ];
    }
}
