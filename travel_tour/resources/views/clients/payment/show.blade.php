@extends('layouts.client')

@section('title','Chi tiết thanh toán')

@section('content')

<div class="max-w-3xl mx-auto py-10 px-4">

    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

        <!-- HEADER -->
        <div class="bg-blue-600 text-white p-6">
            <h1 class="text-2xl font-bold">HÓA ĐƠN THANH TOÁN</h1>
            <p class="text-sm opacity-90">
                Mã giao dịch: {{ $payment->transaction_code ?? '---' }}
            </p>
        </div>

        <!-- BODY -->
        <div class="p-6 space-y-6">

            <!-- Booking info -->
            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <p class="text-gray-500">Mã booking</p>
                    <p class="font-semibold">
                        {{ $payment->booking->booking_code }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Khách hàng</p>
                    <p class="font-semibold">
                        {{ $payment->booking->customer_name }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Số điện thoại</p>
                    <p class="font-semibold">
                        {{ $payment->booking->customer_phone }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Phương thức</p>
                    <p class="font-semibold uppercase">
                        {{ $payment->method }}
                    </p>
                </div>

            </div>

            <!-- Divider -->
            <hr>

            <!-- Payment info -->
            <div class="space-y-3">

                <div class="flex justify-between">
                    <span class="text-gray-600">Số tiền</span>
                    <span class="font-bold text-red-600 text-lg">
                        {{ number_format($payment->amount) }} VNĐ
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Trạng thái</span>

                    @php
                        $statusColor = match($payment->status){
                            'paid' => 'bg-green-100 text-green-700',
                            'failed' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700'
                        };
                    @endphp

                    <span class="px-3 py-1 rounded-lg font-semibold {{ $statusColor }}">
                        {{ $payment->status_text }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Loại thanh toán</span>

                    @php
                        $typeText = match($payment->type){
                            'deposit' => 'Thanh toán cọc',
                            'final' => 'Thanh toán đầy đủ',
                            'extra' => 'Thanh toán bổ sung',
                            default => $payment->type
                        };

                        $typeColor = match($payment->type){
                            'deposit' => 'bg-yellow-100 text-yellow-700',
                            'final' => 'bg-green-100 text-green-700',
                            'extra' => 'bg-blue-100 text-blue-700',
                            default => 'bg-gray-100 text-gray-700'
                        };
                    @endphp

                    <span class="px-3 py-1 rounded-lg font-semibold {{ $typeColor }}">
                        {{ $typeText }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Thời gian thanh toán</span>
                    <span>
                        {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-' }}
                    </span>
                </div>

            </div>

            <!-- Divider -->
            <hr>

            <!-- Note -->
            <div class="text-sm text-gray-500">
                * Đây là hóa đơn điện tử. Vui lòng liên hệ hỗ trợ nếu có vấn đề.
            </div>

        </div>

        <!-- FOOTER -->
        <div class="bg-gray-50 p-4 text-center">

            <a href="{{ route('booking.show', $payment->booking->id) }}"
               class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Xem booking
            </a>

            <a href="{{ route('payment.history') }}"
               class="ml-2 px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Quay lại
            </a>

        </div>

    </div>

</div>

@endsection