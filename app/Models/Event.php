<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['organizer_id', 'category_id', 'name', 'slug', 'description', 'banner', 'location', 'start_date', 'end_date', 'capacity', 'status'];

    public function eventOrganizer()
    {
        return $this->belongsTo(EventOrganizer::class);
    }
    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class);
    }
    public function getBannerUrlAttribute(): string
    {
        return minio_url($this->banner);
    }
}