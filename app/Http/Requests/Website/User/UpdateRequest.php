<?php

namespace App\Http\Requests\Website\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['between:2,100'],
            'gender' => [Rule::in([0,1])],
            'phone_number' => ['string'],
            'image' => ['mimes:png,jpg,jpeg'],
        ];
    }
}
