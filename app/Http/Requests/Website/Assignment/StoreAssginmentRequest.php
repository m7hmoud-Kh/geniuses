<?php

namespace App\Http\Requests\Website\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssginmentRequest extends FormRequest
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
            'module_id' => ['required','exists:modules,id'],
            'attachment' => ['required','mimes:jpg,png,jpeg,pdf,mp4,mov,mp3']
        ];
    }
}
