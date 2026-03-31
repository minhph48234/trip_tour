<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_schedules', function (Blueprint $table) {

            $table->id();

            $table->foreignId('guide_id')
                ->constrained('tour_guides')
                ->cascadeOnDelete();

            $table->date('work_date');

            $table->enum('status',['available','assigned','off'])->default('available');

            $table->string('note')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide_schedules');
    }
};
