<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutSectionResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'cards' => $this->cards ? $this->cards->map(function ($card) {
                return [
                    'id' => $card->id,
                    'title' => $card->title,
                    'description' => $card->description,
                    'icon_name' => $card->icon_name,
                    'icon_image' => $card->icon_image,
                    'icon_image_url' => $card->icon_image_url,
                    'steps' => $card->steps,
                ];
            })->values()->all() : [],
            'points' => collect($this->points)->map(function ($point) {
                return [
                    'number' => $point['number'] ?? null,
                    'title' => $point['title'] ?? null,
                    'description' => $point['description'] ?? null,
                ];
            })->values()->all(),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
