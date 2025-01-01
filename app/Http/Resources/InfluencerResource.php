<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerResource extends JsonResource
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
            'email' => $this->email,
            'referal_token' => $this->referal_token,
            'phone_number' => $this->phone_number,
            'percentage' => $this->percentage,
            'status' => $this->status,
            'users_count' => $this->users_count,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'created_at' => $this->created_at
        ];
    }
}
