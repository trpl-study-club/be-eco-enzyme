<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ContactItem::class)->orderBy('order');
    }

    /**
     * Helper accessor for direct location string from active items.
     */
    public function getLocationAttribute(): ?string
    {
        $activeItems = $this->items->filter(fn ($item) => $item->is_active !== false);

        return $activeItems->firstWhere('type', 'location')?->value
            ?? $activeItems->first(fn ($item) => strtolower($item->label) === 'lokasi')?->value;
    }

    /**
     * Helper accessor for direct email string from active items.
     */
    public function getEmailAttribute(): ?string
    {
        $activeItems = $this->items->filter(fn ($item) => $item->is_active !== false);

        return $activeItems->firstWhere('type', 'email')?->value
            ?? $activeItems->first(fn ($item) => strtolower($item->label) === 'email')?->value;
    }

    /**
     * Helper accessor for direct whatsapp string from active items.
     */
    public function getWhatsappAttribute(): ?string
    {
        $activeItems = $this->items->filter(fn ($item) => $item->is_active !== false);

        return $activeItems->firstWhere('type', 'whatsapp')?->value
            ?? $activeItems->first(fn ($item) => strtolower($item->label) === 'whatsapp')?->value;
    }
}
