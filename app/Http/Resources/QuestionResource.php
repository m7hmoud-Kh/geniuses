<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question' => json_decode($this->question),
            'point' => $this->point,
            'explanation' => $this->explanation,
            'image' => new MediaResource($this->whenLoaded('mediaFirst')),
            'ImagePath' => $this->whenLoaded('mediaFirst',Question::DIR),
            'exam' => new ExamResource($this->whenLoaded('exam')),
            'options' => OptionResource::collection($this->whenLoaded('options')),
            'created_at' => $this->created_at
        ];
    }
}
