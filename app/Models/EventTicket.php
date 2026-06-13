<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    protected $fillable = ['event_id', 'name', 'description', 'price', 'quota', 'sales_start', 'sales_end', 'status'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}