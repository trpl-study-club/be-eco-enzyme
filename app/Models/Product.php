<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_section_id',
        'name',
        'description',
        'benefit',
        'detail',
        'specs',
        'price',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'specs' => 'array',
        'is_active' => 'boolean',
    ];

    public function productSection(): BelongsTo
    {
        return $this->belongsTo(ProductSection::class);
    }

    public function detailImages(): HasMany
    {
        return $this->hasMany(ProductDetailImage::class)->orderBy('order');
    }

    public function getPriceFormattedAttribute(): ?string
    {
        return formatRupiah($this->price);
    }
}
