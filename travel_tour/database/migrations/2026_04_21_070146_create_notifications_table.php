<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            // UUID chính
            $table->uuid('id')->primary();

            // Class Notification (VD: App\Notifications\GuideAssignedNotification)
            $table->string('type');

            /*
            |--------------------------------------------------------------------------
            | NOTIFIABLE (RẤT QUAN TRỌNG)
            |--------------------------------------------------------------------------
            | Cho phép dùng cho nhiều model (TourGuide, User...)
            | gồm:
            | - notifiable_id
            | - notifiable_type
            */
            $table->morphs('notifiable');

            /*
            |--------------------------------------------------------------------------
            | DATA (JSON)
            |--------------------------------------------------------------------------
            | Lưu nội dung thông báo
            */
            $table->text('data');

            // Đã đọc hay chưa
            $table->timestamp('read_at')->nullable();

            // created_at, updated_at
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX (🔥 TỐI ƯU)
            |--------------------------------------------------------------------------
            */
            $table->index(['notifiable_id', 'notifiable_type']);
            $table->index('read_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};