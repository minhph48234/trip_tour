<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideAssignment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'guide_id',
        'trip_id',
        'group_id',
        'assigned_at'
    ];

    public function guide()
    {
        return $this->belongsTo(TourGuide::class,'guide_id');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}