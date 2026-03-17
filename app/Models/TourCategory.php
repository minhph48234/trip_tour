<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'status'
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class,'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(TourCategory::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TourCategory::class,'parent_id');
    }
}