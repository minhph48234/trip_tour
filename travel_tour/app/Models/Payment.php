<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // ❌ KHÔNG dùng timestamps vì bảng chưa có created_at, updated_at
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'status',
        'transaction_code',
        'vnp_txn_ref',
        'vnp_response_code',
        'paid_at'
    ];

    // ✅ Ép kiểu dữ liệu (FIX lỗi format())
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
    ACCESSOR (hiển thị đẹp)
    =================================
    */

    // Trạng thái tiếng Việt
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'paid' => 'Đã thanh toán',
            'failed' => 'Thất bại',
            default => $this->status
        };
    }

    // Màu trạng thái (dùng cho CSS)
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'paid' => 'green',
            'failed' => 'red',
            default => 'gray'
        };
    }
}