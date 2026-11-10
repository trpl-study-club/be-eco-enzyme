<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AboutSectionCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_section_id',
        'title',
        'description',
        'icon_name',
        'icon_image',
        'steps',
    ];

    protected $casts = [
        'steps' => 'integer',
    ];

    protected $touches = ['aboutSection'];

    /**
     * Get the about section that owns this card.
     */
    public function aboutSection(): BelongsTo
    {
        return $this->belongsTo(AboutSection::class);
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
