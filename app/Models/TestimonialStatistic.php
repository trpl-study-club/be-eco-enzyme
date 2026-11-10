<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialStatistic extends Model
{
    protected $fillable = ['testimonial_section_id', 'value', 'description'];

    protected $touches = ['testimonialSection'];

    public function testimonialSection()
    {
        return $this->belongsTo(TestimonialSection::class);
    }
}
