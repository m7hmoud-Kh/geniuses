<?php

namespace App\Http\Requests\Dashboard\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExamRequest extends FormRequest
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
            'name' => ['required','string','unique:exams'],
            'time_in_min' => ['numeric'],
            'type' =>  ['required',Rule::in(['mcq','flash','table'])],
            'module_id' => ['required','exists:modules,id']
        ];
    }
}
