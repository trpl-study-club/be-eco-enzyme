<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactItemResource extends JsonResource
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
            'type' => $this->type,
            'label' => $this->label,
            'value' => $this->value,
            'icon_name' => $this->icon_name,
            'icon_image' => $this->icon_image,
            'icon_image_url' => $this->icon_image_url,
            'order' => $this->order,
        ];
    }
}
