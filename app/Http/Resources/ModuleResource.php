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
            'category_id' => $this->category_id,
            'attachments' => MediaResource::collection($this->whenLoaded('attachments')),
            'exams' => ExamResource::collection($this->whenLoaded('exams')),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'feedbacks' => FeedbackResource::collection($this->whenLoaded('feedbacks')),
            'ImagePath' => $this->whenLoaded('attachments',Module::DIR),
            'subscription' => SubscriptionResource::collection($this->whenLoaded('subscription')),
            'created_at' => $this->created_at,
        ];
    }
}
