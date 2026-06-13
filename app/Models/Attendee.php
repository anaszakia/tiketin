<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = ['order_item_id', 'name', 'email', 'phone', 'ticket_code', 'qr_code', 'status'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}