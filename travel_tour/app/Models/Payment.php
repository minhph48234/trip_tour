<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'status',
        'type',
        'transaction_code',
        'vnp_txn_ref',
        'vnp_response_code',
        'paid_at',
        'admin_confirm_status' // ✅ THÊM MỚI
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /*
    =================================
    RELATIONSHIP
    =================================
    */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /*
    =================================
    ACCESSOR
    =================================
    */

    // trạng thái thanh toán
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thất bại',
            'refunded' => 'Hoàn tiền',
            default => $this->status
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary'
        };
    }

    // loại thanh toán
    public function getTypeTextAttribute()
    {
        return match ($this->type) {
            'deposit' => 'Thanh toán cọc',
            'final' => 'Thanh toán còn lại',
            'extra' => 'Phát sinh',
            default => $this->type
        };
    }

    /*
    =================================
    ADMIN CONFIRM STATUS (🔥 MỚI)
    =================================
    */

    public function getAdminConfirmTextAttribute()
    {
        return match ($this->admin_confirm_status) {
            'pending' => 'Chờ admin xác nhận',
            'confirmed' => 'Đã xác nhận',
            default => 'Chưa xác định'
        };
    }

    public function getAdminConfirmColorAttribute()
    {
        return match ($this->admin_confirm_status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            default => 'secondary'
        };
    }
}