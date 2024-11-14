<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'name' => ['string', Rule::unique('categories')->ignore($this->category->id)],
            'price' => [ 'numeric', 'min:1'],
            'allow_in_days' => [ 'numeric', 'min:1'],
            'image' => ['nullable', 'mimes:jpg,png,jpeg',],
            'status' => ['boolean']
        ];
    }
}
