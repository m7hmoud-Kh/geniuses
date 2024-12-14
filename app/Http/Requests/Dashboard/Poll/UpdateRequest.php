<?php

namespace App\Http\Requests\Dashboard\Poll;

use App\Models\Poll;
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
        $poll = $this->route('poll');
        return [
            'poll' => ['string',Rule::unique('polls','poll')->ignore($poll->id)],
            'status' => ['boolean']
        ];
    }
}
