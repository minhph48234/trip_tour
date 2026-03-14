<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'attendance_id',
        'booking_customer_id',
        'status',
        'note',
        'marked_at'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function customer()
    {
        return $this->belongsTo(BookingCustomer::class,'booking_customer_id');
    }
}
