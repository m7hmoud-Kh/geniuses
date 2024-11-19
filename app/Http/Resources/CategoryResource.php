<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'allow_in_days' => $this->allow_in_days,
            'status' => $this->status,
            'mediaFirst' => new MediaResource($this->whenLoaded('mediaFirst')),
            'ImagePath' => $this->whenLoaded('mediaFirst',Category::DIR),
            'created_at' => $this->created_at,
        ];
    }
}
