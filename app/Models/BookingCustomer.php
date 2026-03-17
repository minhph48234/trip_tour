<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingCustomer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'name',
        'gender',
        'birthdate',
        'phone',
        'type'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function attendanceDetails()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}
