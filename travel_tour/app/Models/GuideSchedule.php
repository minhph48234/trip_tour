<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideSchedule extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'guide_id',
        'work_date',
        'status',
        'note'
    ];

    public function guide()
    {
        return $this->belongsTo(TourGuide::class,'guide_id');
    }
}   
