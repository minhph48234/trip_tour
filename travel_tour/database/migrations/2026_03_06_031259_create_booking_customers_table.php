<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_customers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->string('name');

            $table->enum('gender',['male','female']);

            $table->date('birthdate')->nullable();

            $table->string('phone')->nullable();

            $table->enum('type',['adult','child']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_customers');
    }
};