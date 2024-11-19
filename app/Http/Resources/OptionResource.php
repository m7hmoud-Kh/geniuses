<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'option' => json_decode($this->option),
            'is_correct' => $this->is_correct,
            'question' => new QuestionResource($this->whenLoaded('question')),
            'created_at' => $this->created_at
        ];
    }
}
