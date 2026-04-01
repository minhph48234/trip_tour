<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'tour_id',
        'trip_id',
        'group_id',
        'booking_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'quantity',
        'total_price',
        'note',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function customers()
    {
        return $this->hasMany(BookingCustomer::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function updateStatus()
    {
        $paid = $this->paid_amount ?? 0;
        $deposit = $this->deposit_amount ?? 0;
        $total = $this->total_price ?? 0;

        if ($paid >= $total) {
            $this->status = 'paid';
        } elseif ($paid > $deposit) {
            $this->status = 'deposit_paid';
        } else {
            $this->status = 'pending';
        }

        $this->save();
    }
}
