<?php

namespace App\Http\Requests\Dashboard\Lesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends FormRequest
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
            'name' => ['string',Rule::unique('lessons')->ignore($this->lesson->id)],
            'url' => ['url:https'],
            'description' => ['string'],
            'module_id' => ['exists:modules,id']
        ];
    }
}
