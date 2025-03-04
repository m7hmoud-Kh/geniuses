<?php

namespace App\Http\Requests\Dashboard\Module;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleRequest extends FormRequest
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
            'name' => ['required','string','unique:modules'],
            'price' => ['required','numeric'],
            'allow_in_days' => ['required','numeric'],
            'category_id' => ['required','exists:categories,id'],
            'attachments.*' => ['mimes:pdf']
        ];
    }
}
