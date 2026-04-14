<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use Carbon\Carbon;

class CloseTripBeforeStart extends Command
{
    protected $signature = 'trip:auto-close';
    protected $description = 'Tự động đóng tour trước 2 ngày khởi hành';

    public function handle()
    {
        // 🔥 ngày hiện tại
        $today = Carbon::today();

        // 🔥 lấy các trip cần đóng
        $trips = Trip::where('status', 'open')
            ->whereDate('start_date', '<=', $today->copy()->addDays(2))
            ->get();

        foreach ($trips as $trip) {

            $trip->update([
                'status' => 'full' // 👉 hoặc 'closed' nếu bạn muốn tạo thêm enum
            ]);

            $this->info("Đã đóng trip ID: " . $trip->id);
        }

        return 0;
    }
}