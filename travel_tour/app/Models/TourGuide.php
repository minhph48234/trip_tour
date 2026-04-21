<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TourGuide extends Model
{
    use Notifiable;
    
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'experience',
        'status'
    ];

    public function assignments()
    {
        return $this->hasMany(GuideAssignment::class,'guide_id');
    }

    public function schedules()
    {
        return $this->hasMany(GuideSchedule::class,'guide_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class,'guide_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}