<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('attendance_id')
                ->constrained('attendances')
                ->cascadeOnDelete();

            $table->foreignId('booking_customer_id')
                ->constrained('booking_customers')
                ->cascadeOnDelete();

            $table->enum('status',['present','absent'])->default('present');

            $table->string('note')->nullable();

            $table->timestamp('marked_at')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_details');
    }
};