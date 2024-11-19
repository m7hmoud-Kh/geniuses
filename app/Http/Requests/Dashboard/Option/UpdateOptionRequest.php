<?php

namespace App\Http\Requests\Dashboard\Option;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOptionRequest extends FormRequest
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
            'option' => [function ($attribute, $value, $fail) {
                if ($this->type == 'table') {
                    if (!is_array($value) && is_null(json_decode($value, true))) {
                        $fail('The Option must be a valid JSON or array when type is table.');
                    }
                }

                if (in_array($this->type, ['flash', 'mcq']) && !is_string($value)) {
                    $fail('The Option must be a string when type is flash or mcq.');
                }
            }],
            'is_correct' => ['boolean']
        ];
    }
}
