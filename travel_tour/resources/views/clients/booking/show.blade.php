@extends('layouts.client')

@php
use Illuminate\Support\Str;

/* LẤY TOUR */
$tour = $booking->trip->tour;

/* ======================
   ẢNH ĐẠI DIỆN
====================== */
$displayUrl = null;

if ($tour->thumbnail ?? null) {

    if (Str::startsWith($tour->thumbnail, ['http://','https://'])) {
        $displayUrl = $tour->thumbnail;
    }
    elseif (file_exists(public_path('storage/'.$tour->thumbnail))) {
        $displayUrl = asset('storage/'.$tour->thumbnail);
    }
}

if (!$displayUrl) {
    $displayUrl = 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?q=80&w=1200';
}

/* ======================
   TRẠNG THÁI BOOKING
====================== */
switch ($booking->status) {

    case 'pending':
        $statusText = 'Chờ thanh toán';
        $statusColor = 'bg-yellow-100 text-yellow-700';
        break;

    case 'deposit_paid':
        $statusText = 'Đã đặt cọc';
        $statusColor = 'bg-blue-100 text-blue-700';
        break;

    case 'paid':
        $statusText = 'Đã thanh toán đủ';
        $statusColor = 'bg-green-100 text-green-700';
        break;

    case 'completed':
        $statusText = 'Hoàn thành';
        $statusColor = 'bg-green-200 text-green-800';
        break;

    case 'canceled':
        $statusText = 'Đã hủy';
        $statusColor = 'bg-red-100 text-red-700';
        break;

    default:
        $statusText = $booking->status;
        $statusColor = 'bg-gray-100 text-gray-700';
}

/* ======================
   🔥 TRẠNG THÁI ADMIN (SỬA CHUẨN)
====================== */
$isConfirmed = $booking->payments
    ->where('admin_confirm_status','confirmed')
    ->count() > 0;

/* ======================
   TÍNH TIỀN
====================== */

$totalPaid = $booking->payments->where('status','paid')->sum('amount');

$deposit = $booking->payments
    ->where('type','deposit')
    ->where('status','paid')
    ->sum('amount');

$final = $booking->payments
    ->where('type','final')
    ->where('status','paid')
    ->sum('amount');

$remaining = $booking->total_price - $totalPaid;

@endphp

@section('title', $tour->name)

@section('content')

<div class="max-w-6xl mx-auto py-10 px-4">

{{-- ẢNH TOUR --}}
<div class="mb-8">
    <img src="{{ $displayUrl }}"
         class="w-full h-[420px] object-cover rounded-2xl shadow-lg"
         alt="{{ $tour->name }}">
</div>

{{-- TÊN TOUR --}}
<div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        {{ $tour->name }}
    </h1>

    <div class="text-3xl font-black text-red-600 mt-4 md:mt-0">
        {{ number_format($tour->price) }} VNĐ
    </div>

</div>

{{-- THÔNG TIN BOOKING --}}
<div class="bg-white shadow-lg rounded-2xl p-6 mb-10">

    <h2 class="text-xl font-bold mb-4">Thông tin đặt tour</h2>

    <p><b>Mã booking:</b> {{ $booking->booking_code }}</p>

    <p><b>Ngày khởi hành:</b>
        {{ \Carbon\Carbon::parse($booking->trip->start_date)->format('d/m/Y') }}
    </p>

    <p><b>Ngày kết thúc:</b>
        {{ \Carbon\Carbon::parse($booking->trip->end_date)->format('d/m/Y') }}
    </p>

    <hr class="my-3">

    <p><b>Tổng tiền:</b>
        <span class="text-red-600 font-bold">
            {{ number_format($booking->total_price) }} VNĐ
        </span>
    </p>

    <p><b>Đã thanh toán:</b>
        <span class="text-green-600 font-bold">
            {{ number_format($totalPaid) }} VNĐ
        </span>
    </p>

    <p><b>Tiền cọc:</b>
        <span class="text-blue-600 font-semibold">
            {{ number_format($deposit) }} VNĐ
        </span>
    </p>

    <p><b>số tiền đã thanh toán trong hoá lần thanh toán này:</b>
        <span class="text-purple-600 font-semibold">
            {{ number_format($final) }} VNĐ
        </span>
    </p>

    <p><b>Còn lại:</b>
        <span class="text-orange-600 font-bold">
            {{ number_format($remaining) }} VNĐ
        </span>
    </p>

    <hr class="my-3">

    {{-- TRẠNG THÁI --}}
    <p class="mb-2">
        <b>Trạng thái đơn:</b>
        <span class="px-3 py-1 rounded-lg font-semibold {{ $statusColor }}">
            {{ $statusText }}
        </span>
    </p>

    {{-- 🔥 TRẠNG THÁI ADMIN --}}
    <p>
        <b>Xác nhận admin:</b>

        @if($isConfirmed)
            <span class="px-3 py-1 rounded-lg bg-green-100 text-green-700 font-semibold">
                ✔ Đã xác nhận
            </span>
        @else
            <span class="px-3 py-1 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">
                ⏳ Chờ xác nhận
            </span>
        @endif
    </p>

    {{-- NÚT THANH TOÁN --}}
    @if($booking->status !== 'paid' && $booking->status !== 'completed' && $booking->status !== 'canceled')

        @if($totalPaid < $booking->deposit_amount)
            <a href="{{ route('payment.vnpay',$booking->id) }}"
               class="inline-block mt-4 bg-yellow-500 text-white px-5 py-2 rounded-lg hover:bg-yellow-600">
                Thanh toán cọc
            </a>

        @elseif($totalPaid < $booking->total_price)
            <a href="{{ route('payment.vnpayFinal',$booking->id) }}"
               class="inline-block mt-4 bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">
                Thanh toán phần còn lại
            </a>
        @endif

    @endif

</div>

{{-- LỊCH SỬ THANH TOÁN --}}
@if($booking->payments->count())

<div class="bg-white shadow-lg rounded-2xl p-6 mb-10">

    <h2 class="text-xl font-bold mb-4">Lịch sử thanh toán</h2>

    <table class="w-full text-center border">
        <thead class="bg-slate-100">
            <tr>
                <th class="p-3 border">Loại</th>
                <th class="p-3 border">Số tiền</th>
                <th class="p-3 border">Trạng thái</th>
                <th class="p-3 border">Admin</th>
                <th class="p-3 border">Thời gian</th>
            </tr>
        </thead>

        <tbody>
            @foreach($booking->payments as $pay)
            <tr>
                <td class="p-3 border">
                    {{ $pay->type_text ?? $pay->type }}
                </td>

                <td class="p-3 border text-red-600 font-bold">
                    {{ number_format($pay->amount) }} VNĐ
                </td>

                <td class="p-3 border">
                    {{ $pay->status_text }}
                </td>

                <td class="p-3 border">
                    @if($pay->admin_confirm_status == 'confirmed')
                        <span class="text-green-600 font-semibold">✔ Đã xác nhận</span>
                    @else
                        <span class="text-yellow-600 font-semibold">⏳ Chờ xác nhận</span>
                    @endif
                </td>

                <td class="p-3 border">
                    {{ optional($pay->paid_at)->format('d/m/Y H:i') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endif

{{-- BACK --}}
<div class="text-center mt-10">
    <a href="{{ route('booking.history') }}"
       class="bg-slate-800 hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-bold transition">
        Quay lại lịch sử
    </a>
</div>

</div>

@endsection