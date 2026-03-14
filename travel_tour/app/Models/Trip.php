<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = 'trips';

    protected $fillable = [
        'tour_id',
        'start_date',
        'end_date',
        'max_people',
        'current_people',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | CAST DATA TYPE
    |--------------------------------------------------------------------------
    | giúp Laravel hiểu start_date và end_date là kiểu date
    */

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Trip thuộc về 1 tour
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // Trip có nhiều group
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    // Trip có nhiều booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // phân công hướng dẫn viên
    public function guideAssignments()
    {
        return $this->hasMany(GuideAssignment::class);
    }

    // điểm danh
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}