<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'phoneNumber' => $this->phone_number,
            'gender' => $this->gender ? 'Male' : 'Female',
            'email_verified_at' => $this->email_verified_at,
            'feedbacks' => $this->whenLoaded('feedbacks', FeedbackResource::collection($this->whenLoaded('feedbacks'))),
            'subscriptions' => $this->whenLoaded('subscriptions', SubscriptionResource::collection($this->whenLoaded('subscriptions'))),
            'created_at' => $this->created_at,
        ];
    }
}
