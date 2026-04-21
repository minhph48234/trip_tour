<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    // ⚠️ Nếu bảng KHÔNG có created_at, updated_at thì giữ false
    public $timestamps = false;

    /*
    ===============================
    FILLABLE (QUAN TRỌNG)
    ===============================
    */
    protected $fillable = [
        'trip_id',
        'type',
        'min_people',      // 🔥 FIX LỖI CHÍNH
        'max_people',
        'current_people',
        'status',
        'progress',
        'note',
        'guide_id',
        'transfer_status'
    ];

    /*
    ===============================
    CONSTANT (TRÁNH SAI LOGIC)
    ===============================
    */
    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_FULL      = 'full';
    const STATUS_CANCELLED = 'cancelled';

    const PROGRESS_PENDING   = 'pending';
    const PROGRESS_ONGOING   = 'ongoing';
    const PROGRESS_COMPLETED = 'completed';

    const TYPE_PRIVATE = 'private';
    const TYPE_COUPLE  = 'couple';
    const TYPE_GROUP   = 'group';

    /*
    ===============================
    RELATIONSHIPS
    ===============================
    */

    // Group thuộc Trip
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // Hướng dẫn viên
    public function guide()
    {
        return $this->belongsTo(TourGuide::class, 'guide_id');
    }

    // Danh sách booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /*
    ===============================
    HELPER FUNCTIONS
    ===============================
    */

    // 🔥 Số chỗ còn lại
    public function getAvailableSlotsAttribute()
    {
        return $this->max_people - $this->current_people;
    }

    // 🔥 Đủ số lượng tối thiểu chưa
    public function isEnoughPeople()
    {
        return $this->current_people >= $this->min_people;
    }

    // 🔥 Đã full chưa
    public function isFull()
    {
        return $this->current_people >= $this->max_people;
    }

    /*
    ===============================
    AUTO UPDATE STATUS
    ===============================
    */
    public function updateStatus()
    {
        if ($this->isFull()) {
            $this->status = self::STATUS_FULL;
        } elseif ($this->isEnoughPeople()) {
            $this->status = self::STATUS_CONFIRMED;
        } else {
            $this->status = self::STATUS_PENDING;
        }

        $this->save();
    }
}