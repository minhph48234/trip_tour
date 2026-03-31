<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->enum('method',['cash','vnpay','momo']);

            $table->decimal('amount',12,2);

             // mã đơn hàng gửi sang VNPay
            $table->string('vnp_txn_ref')
                ->nullable();

            // mã phản hồi từ VNPay
            $table->string('vnp_response_code')
                ->nullable();
                
            $table->enum('status',['pending','paid','failed','refunded'])->default('pending');

            $table->string('transaction_code')->nullable();

            $table->timestamp('paid_at')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
