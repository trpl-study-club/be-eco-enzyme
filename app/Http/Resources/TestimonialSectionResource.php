<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialSectionResource extends JsonResource
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
            'is_active' => (bool) $this->is_active,
            'statistics' => $this->whenLoaded('statistics', function () {
                return $this->statistics->map(function ($stat) {
                    return [
                        'id' => $stat->id,
                        'value' => $stat->value,
                        'description' => $stat->description,
                    ];
                });
            }),
            'testimonials' => $this->whenLoaded('testimonials', function () {
                return $this->testimonials->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quote' => $item->quote,
                        'name' => $item->name,
                        'location' => $item->location,
                    ];
                });
            }),
        ];
    }
}
