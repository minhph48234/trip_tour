<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'trip_id',
        'type',
        'max_people',
        'current_people',
        'status',
        'note',
        'guide_id'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function guide()
    {
        return $this->belongsTo(TourGuide::class,'guide_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}