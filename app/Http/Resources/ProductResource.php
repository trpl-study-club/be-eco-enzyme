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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'detail' => $this->detail ?? $this->description,
            'price' => formatRupiah($this->price) ?? $this->price,
            'order' => (int) $this->order,
            'images' => $images,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
