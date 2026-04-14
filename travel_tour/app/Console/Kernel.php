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
        \App\Console\Commands\CloseTripBeforeStart::class, 
    ];

    /**
     * Định nghĩa lịch chạy command (Scheduler)
     */
    protected function schedule(Schedule $schedule): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. UPDATE TRẠNG THÁI HƯỚNG DẪN VIÊN
        |--------------------------------------------------------------------------
        */
        $schedule->command('guide:update-status')->daily();

        /*
        |--------------------------------------------------------------------------
        | 2. AUTO ĐÓNG TRIP TRƯỚC 2 NGÀY
        |--------------------------------------------------------------------------
        */
        $schedule->command('trip:auto-close')->daily();

        /*
        |--------------------------------------------------------------------------
        | 🔥 TEST NHANH (CHỈ DÙNG KHI DEV)
        |--------------------------------------------------------------------------
        */
        // $schedule->command('trip:auto-close')->everyMinute();
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