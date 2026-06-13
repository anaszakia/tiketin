<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventStaff extends Model
{
    protected $fillable = ['event_id', 'user_id', 'event_role_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function eventRole()
    {
        return $this->belongsTo(EventRole::class);
    }
}