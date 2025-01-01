<?php

namespace App\Http\Resources;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'module_id' => $this->module_id,
            'attachment' => new MediaResource($this->mediaFirst),
            'ImagePath' => Assignment::DIR,
            'user' => new UserResource($this->whenLoaded('user')),
            'module' => new ModuleResource($this->whenLoaded('module')),
            'created_at' => $this->created_at,
        ];
    }
}
