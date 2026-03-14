<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'status',
        'transaction_code',
        'paid_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
