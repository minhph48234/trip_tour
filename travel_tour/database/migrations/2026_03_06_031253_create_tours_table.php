<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('tour_categories')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('departure_location');
            $table->string('destination');

            $table->string('duration');
            $table->string('transport')->nullable();

            $table->decimal('price',12,2);
            $table->decimal('child_price',12,2)->nullable();

            $table->integer('max_people');

            $table->text('description')->nullable();
            $table->text('highlight')->nullable();

            $table->string('thumbnail')->nullable();

            $table->enum('status',['active','inactive'])->default('active');

            // 👇 thêm cột lượt xem
            $table->integer('views')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};