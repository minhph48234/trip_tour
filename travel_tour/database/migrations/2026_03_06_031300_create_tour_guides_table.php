<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_guides', function (Blueprint $table) {

            $table->id();
            // khóa ngoại liên kết bảng users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();

            $table->integer('experience')->default(0);

            $table->enum('status',['available','busy','inactive'])->default('available');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_guides');
    }
};
