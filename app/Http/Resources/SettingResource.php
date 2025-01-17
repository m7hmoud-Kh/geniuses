<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'key' => $this->key,
            'value_en' => $this->value_en,
            'value_ar' => $this->value_ar,
            'image' => $this->image,
            'imagePath' => $this->image ? Setting::DIR : null
        ];
    }
}
