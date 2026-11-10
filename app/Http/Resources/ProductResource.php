<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];

        if ($this->image) {
            $images[] = asset(Storage::url($this->image));
        }

        if ($this->relationLoaded('detailImages')) {
            foreach ($this->detailImages as $detailImage) {
                if ($detailImage->image) {
                    $images[] = asset(Storage::url($detailImage->image));
                }
            }
        }

        $specs = is_array($this->specs) ? $this->specs : [];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'benefit' => $this->benefit,
            'detail' => $this->detail,
            'price' => $this->price,
            'order' => $this->order,
            'images' => $images,
            'specs' => [
                'netto' => $specs['netto'] ?? null,
                'packaging' => $specs['packaging'] ?? null,
                'shape' => $specs['shape'] ?? null,
                'suitability' => $specs['suitability'] ?? null,
                'stock' => $specs['stock'] ?? null,
                'certification' => $specs['certification'] ?? null,
                'ingredients' => $specs['ingredients'] ?? null,
                'usage' => $specs['usage'] ?? null,
            ],
        ];
    }
}
