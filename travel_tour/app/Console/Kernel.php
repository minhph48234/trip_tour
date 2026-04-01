<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Các command sẽ được đăng ký ở đây
     */
    protected $commands = [
        \App\Console\Commands\UpdateGuideStatus::class,
    ];

    /**
     * Định nghĩa lịch chạy command (Scheduler)
     */
    protected function schedule(Schedule $schedule): void
    {
        // chạy mỗi ngày 1 lần
        $schedule->command('guide:update-status')->daily();

        // nếu muốn test nhanh có thể dùng:
        // $schedule->command('guide:update-status')->everyMinute();
    }

    /**
     * Load các command từ thư mục Commands
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}