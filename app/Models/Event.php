<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['organizer_id', 'category_id', 'name', 'slug', 'description', 'banner', 'location', 'start_date', 'end_date', 'capacity', 'status'];

    public function eventOrganizer()
    {
        return $this->belongsTo(EventOrganizer::class, 'organizer_id');
    }

    public function organizer()
    {
        return $this->eventOrganizer();
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function category()
    {
        return $this->eventCategory();
    }

    public function getBannerUrlAttribute(): string
    {
        return minio_url($this->banner);
    }
}
