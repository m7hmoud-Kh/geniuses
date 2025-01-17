<?php

namespace App\Http\Requests\Dashboard\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value_en' => [
                'nullable',
                'required_without:image',
            ],
            'value_ar' => [
                'nullable',
                'required_without:image',
            ],
            'image' => [
                'nullable',
                'required_without:value_en',
            ],
        ];
    }
}
