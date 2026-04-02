<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('tour_id')
                ->constrained('tours')
                ->cascadeOnDelete();

            $table->foreignId('trip_id')
                ->constrained('trips')
                ->cascadeOnDelete();

            $table->foreignId('group_id')
                ->nullable()
                ->constrained('groups')
                ->nullOnDelete();

            $table->string('booking_code')->unique();

            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            $table->integer('quantity');

            $table->decimal('total_price',12,2);

            $table->text('note')->nullable();

            $table->decimal('deposit_amount',12,2)->default(0); // số tiền cần cọc
            $table->decimal('paid_amount',12,2)->default(0);    // đã trả

            $table->enum('status', [
                'pending',        // vừa đặt
                'deposit_paid',   // đã cọc
                'paid',           // đã thanh toán full
                'completed',      // đi xong
                'payment_confirmed', // đã xác nhận thanh toán
                'canceled'
            ])->default('pending');                                                     

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};