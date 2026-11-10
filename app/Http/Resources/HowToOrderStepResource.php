<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HowToOrderStepResource extends JsonResource
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
            'how_to_order_section_id' => $this->how_to_order_section_id,
            'title' => $this->title,
            'description' => $this->description,
            'icon_name' => $this->icon_name,
            'icon_image' => $this->icon_image,
            'icon_image_url' => $this->icon_image_url,
            'step_order' => $this->step_order,
        ];
    }
}
