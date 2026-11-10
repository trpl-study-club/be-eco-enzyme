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
     * Helper accessor for direct location string.
     */
    public function getLocationAttribute(): ?string
    {
        return $this->items->firstWhere('type', 'location')?->value
            ?? $this->items->first(fn ($item) => strtolower($item->label) === 'lokasi')?->value;
    }

    /**
     * Helper accessor for direct email string.
     */
    public function getEmailAttribute(): ?string
    {
        return $this->items->firstWhere('type', 'email')?->value
            ?? $this->items->first(fn ($item) => strtolower($item->label) === 'email')?->value;
    }

    /**
     * Helper accessor for direct whatsapp string.
     */
    public function getWhatsappAttribute(): ?string
    {
        return $this->items->firstWhere('type', 'whatsapp')?->value
            ?? $this->items->first(fn ($item) => strtolower($item->label) === 'whatsapp')?->value;
    }
}
