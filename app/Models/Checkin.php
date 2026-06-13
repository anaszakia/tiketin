<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = ['attendee_id', 'officer_id', 'checkin_at', 'location', 'note'];

    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}