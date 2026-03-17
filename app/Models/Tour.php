<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'departure_location',
        'destination',
        'duration',
        'transport',
        'price',
        'child_price',
        'max_people',
        'description',
        'highlight',
        'thumbnail',
        'status',
        'views'
    ];

    public function category()
    {
        return $this->belongsTo(TourCategory::class,'category_id');
    }

    public function bookings()
        {
            return $this->hasMany(Booking::class);
        }
    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function itineraries()
    {
        return $this->hasMany(TourItinerary::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}