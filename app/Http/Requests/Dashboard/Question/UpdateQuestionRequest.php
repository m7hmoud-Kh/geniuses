<?php

namespace App\Http\Requests\Dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'exam_id' => ['exists:exams,id'],
            'question' => [function ($attribute, $value, $fail) {
                if ($this->type == 'table'|| $this->type == 'flash') {
                    // Ensure the question is either a JSON string or a valid array.
                    if (!is_array($value) && is_null(json_decode($value, true))) {
                        $fail('The question must be a valid JSON or array when type is table.');
                    }
                }

                if (in_array($this->type, ['mcq']) && !is_string($value)) {
                    $fail('The question must be a string when type is mcq.');
                }
            }],
            'point' => ['numeric'],
            'image' => ['mimes:png,jpg,jpeg,mp4,mov'],
            'explanation' => ['max:100'],
        ];
    }
}
