<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialItem extends Model
{
    protected $fillable = ['testimonial_section_id', 'quote', 'name', 'location'];

    protected $touches = ['testimonialSection'];

    public function getSubtitleAttribute(): ?string
    {
        return $this->attributes['location'] ?? null;
    }

    public function setSubtitleAttribute(?string $value): void
    {
        $this->attributes['location'] = $value;
    }

    public function testimonialSection()
    {
        return $this->belongsTo(TestimonialSection::class);
    }
}
