<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOrganizer extends Model
{
    protected $fillable = ['user_id', 'organizer_name', 'phone', 'address', 'npwp', 'logo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function get" . Str::studly(logo) . "UrlAttribute(): string
    {
        return minio_url($this->logo);
    }
}