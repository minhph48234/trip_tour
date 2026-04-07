<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {

            $table->id();

            $table->foreignId('trip_id')
                ->constrained('trips')
                ->cascadeOnDelete();

            $table->enum('type',['private','couple','group']);

            $table->integer('max_people');
            $table->integer('current_people')->default(0);

            $table->enum('status',['open','full','closed'])->default('open');
            $table->enum('progress', [
                'pending',     // chưa hoàn thành
                'ongoing',     // đang diễn ra
                'completed'    // hoàn thành
            ])->default('pending');
            $table->string('note')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
