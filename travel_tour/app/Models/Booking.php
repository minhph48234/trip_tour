<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'tour_id',
        'trip_id',
        'group_id',
        'booking_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'quantity',
        'total_price',
        'note',
        'deposit_amount',
        'paid_amount',
        'status'
    ];

    /*
    =================================
    RELATIONSHIP
    =================================
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function customers()
    {
        return $this->hasMany(BookingCustomer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /*
    =================================
    UPDATE STATUS (QUAN TRỌNG)
    =================================
    */
    public function updateStatus()
    {
        // Tổng tiền đã thanh toán từ bảng payments
        $paid = $this->payments()
            ->where('status', 'paid')
            ->sum('amount');

        $total = $this->total_price;
        $deposit = $this->deposit_amount;

        // cập nhật lại paid_amount
        $this->paid_amount = $paid;

        if ($paid >= $total) {
            $this->status = 'paid';
        } elseif ($paid >= $deposit && $deposit > 0) {
            $this->status = 'deposit_paid';
        } else {
            $this->status = 'pending';
        }

        $this->save();
    }

    /*
    =================================
    ACCESSOR
    =================================
    */

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'pending' => 'Chờ xử lý',
            'deposit_paid' => 'Đã đặt cọc',
            'payment_confirmed' => 'Đã xác nhận thanh toán',
            'paid' => 'Đã thanh toán',
            'completed' => 'Hoàn thành',
            'canceled' => 'Đã hủy',
            default => $this->status
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'gray',
            'deposit_paid' => 'yellow',
            'payment_confirmed' => 'blue',
            'paid' => 'green',
            'completed' => 'emerald',
            'canceled' => 'red',
            default => 'gray'
        };
    }
}