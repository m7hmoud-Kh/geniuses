<?php

namespace App\Http\Requests\Dashboard\Influencer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInfluencerRequest extends FormRequest
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
            'name' => ['string'],
            'email' => [Rule::unique('influencers')->ignore($this->influencer->id)],
            'status' => ['boolean'],
            'percentage' => ['min:1','max:100','numeric'],
            'phone_number' => ['string']
        ];
    }
}
