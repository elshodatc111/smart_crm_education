<?php

namespace App\Http\Requests\web;
use Illuminate\Foundation\Http\FormRequest;

class SettingCreateRegionRequest extends FormRequest{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'region_code' => [
                'required',
                'string',
                'max:10',
                'unique:setting_regions,region_code'
            ],
            'region_name' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }
    public function messages(): array{
        return [
            'region_code.required' => 'Hudud kodi kiritilishi shart',
            'region_code.max' => 'Hudud kodi 10 belgidan oshmasligi kerak',
            'region_code.unique' => 'Bu hudud kodi allaqachon mavjud',
            'region_name.required' => 'Hudud nomi kiritilishi shart',
            'region_name.max' => 'Hudud nomi juda uzun',
        ];
    }
    protected function prepareForValidation(){
        $this->merge([
            'region_code' => strtoupper(trim($this->region_code)),
            'region_name' => trim($this->region_name),
        ]);
    }
}
