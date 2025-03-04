<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => ['required','string','unique:categories'],
            'price' => ['required','numeric'],
            'allow_in_days' => ['required','numeric'],
            'image' => ['required','mimes:jpg,png,jpeg'],
            'description' => ['required','string'],
            'instructor_id' => ['required','exists:instructors,id']
        ];
    }
}
