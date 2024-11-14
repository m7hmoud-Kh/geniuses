<?php

namespace App\Http\Requests\Dashboard\Fqa;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFqaRequest extends FormRequest
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
            'question' => ['string'],
            'answer' => ['string'],
            'module_id' => ['exists:modules,id'],
            'status' => ['boolean']
        ];
    }
}
