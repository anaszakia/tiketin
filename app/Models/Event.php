<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organizer_id',
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'banner',
        'gallery_images',
        'location',
        'venue_name',
        'address_detail',
        'city',
        'province',
        'map_url',
        'start_date',
        'end_date',
        'capacity',
        'terms',
        'rundown',
        'contact_name',
        'contact_phone',
        'contact_email',
        'minimum_age',
        'refund_policy',
        'status',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

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

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }

    public function getBannerUrlAttribute(): string
    {
        return minio_url($this->banner);
    }
}
