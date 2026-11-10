<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ContactItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_section_id',
        'type',
        'label',
        'value',
        'icon_name',
        'icon_image',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected $touches = ['contactSection'];

    public function contactSection(): BelongsTo
    {
        return $this->belongsTo(ContactSection::class);
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
