<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HowToOrderSectionResource extends JsonResource
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
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
            'is_active' => $this->is_active,
            'steps' => HowToOrderStepResource::collection($this->whenLoaded('steps')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
