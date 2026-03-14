<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar', 
        'password',
        'role',
        'status'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function guide()
    {
        return $this->hasOne(TourGuide::class,'user_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}