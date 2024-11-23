<?php

namespace App\Http\Resources;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'price' => $this->price,
            'allow_in_days' => $this->allow_in_days,
            'status' => $this->status,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'attachments' => MediaResource::collection($this->whenLoaded('attachments')),
            'ImagePath' => $this->whenLoaded('mediaFirst',Module::DIR),
            'created_at' => $this->created_at,
        ];
    }
}
