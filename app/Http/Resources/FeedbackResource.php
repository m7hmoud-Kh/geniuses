<?php

namespace App\Http\Resources;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'poll' => new PollResource($this->whenLoaded('poll')),
            'rating' => $this->rate,
            'user' => new UserResource($this->whenLoaded('user')),
            'module' => $this->whenLoaded('module', new ModuleResource($this->whenLoaded('module'))),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
