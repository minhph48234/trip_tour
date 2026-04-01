<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('trip_id')
                ->constrained('trips')
                ->cascadeOnDelete();

            $table->foreignId('group_id')
                ->nullable()
                ->constrained('groups')
                ->nullOnDelete();

            $table->foreignId('guide_id')
                ->constrained('tour_guides')
                ->cascadeOnDelete();

            $table->date('attendance_date');

            $table->enum('session',['morning','afternoon','evening']);

            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
