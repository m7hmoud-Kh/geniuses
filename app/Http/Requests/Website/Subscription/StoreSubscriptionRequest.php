<?php

namespace App\Http\Requests\Website\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
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
            'category_id' => [
                'nullable',
                'exists:categories,id',
                'required_without:module_id',
            ],
            'module_id' => [
                'nullable',
                'exists:modules,id',
                'required_without:category_id',
            ]
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('category_id') && $this->input('module_id')) {
                $validator->errors()->add('category_id', 'You cannot provide both category_id and module_id.');
                $validator->errors()->add('module_id', 'You cannot provide both category_id and module_id.');
            }
        });
    }
}
