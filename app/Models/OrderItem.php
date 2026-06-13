<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'ticket_id', 'price', 'discount', 'qty', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function eventTicket()
    {
        return $this->belongsTo(EventTicket::class);
    }
}