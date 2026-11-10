<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class HowToOrderStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'how_to_order_section_id',
        'title',
        'description',
        'icon_name',
        'icon_image',
        'step_order',
    ];

    protected $touches = ['section'];

    protected $appends = [
        'icon_image_url',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(HowToOrderSection::class, 'how_to_order_section_id');
    }

    /**
     * Get the full URL for the custom icon image.
     */
    public function getIconImageUrlAttribute(): ?string
    {
        if (! $this->icon_image) {
            return null;
        }

        return Storage::disk('public')->url($this->icon_image);
    }
}
