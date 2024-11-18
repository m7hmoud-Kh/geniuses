<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'time_in_min' => $this->time_in_min,
            'status' => $this->status,
            'module' => new ModuleResource($this->whenLoaded('module')),
            'questions' => QuestionResource::collection($this->whenLoaded('quesitons')),
            'created_at' => $this->created_at
        ];
    }
}
