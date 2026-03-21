@extends('layouts.client')

@php
use Illuminate\Support\Str;

/* LẤY TOUR TỪ BOOKING */
$tour = $booking->trip->tour;

/* ======================
   XỬ LÝ ẢNH ĐẠI DIỆN
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

    case 'confirmed':
        $statusText = 'Đã thanh toán';
        $statusColor = 'bg-green-100 text-green-700';
        break;

    case 'canceled':
        $statusText = 'Đã hủy';
        $statusColor = 'bg-red-100 text-red-700';
        break;

    default:
        $statusText = $booking->status;
        $statusColor = 'bg-gray-100 text-gray-700';
}

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

{{-- TÊN TOUR + GIÁ --}}
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

<p><b>Tổng tiền:</b>
<span class="text-red-600 font-bold">
{{ number_format($booking->total_price) }} VNĐ
</span>
</p>

<p><b>Trạng thái:</b>
<span class="px-3 py-1 rounded-lg font-semibold {{ $statusColor }}">
{{ $statusText }}
</span>
</p>

</div>

{{-- DANH SÁCH KHÁCH --}}
<div class="mb-12">

<h2 class="text-xl font-bold mb-6">Danh sách khách đi tour</h2>

@if($booking->customers->count())

<div class="bg-white shadow-lg rounded-2xl overflow-hidden">

<table class="w-full">

<thead class="bg-slate-100">

<tr class="text-center">

<th class="p-3 border">Họ tên</th>
<th class="p-3 border">SĐT</th>
<th class="p-3 border">Loại khách</th>

</tr>

</thead>

<tbody>

@foreach($booking->customers as $customer)

<tr class="text-center hover:bg-slate-50">

<td class="p-3 border">
{{ $customer->name }}
</td>

<td class="p-3 border">
{{ $customer->phone }}
</td>

<td class="p-3 border">

@php
$typeText = match($customer->type){
    'adult' => 'Người lớn',
    'child' => 'Trẻ em',
    default => 'Người lớn'
};
@endphp

{{ $typeText }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@else

<p class="text-slate-500">Chưa có khách nào.</p>

@endif

</div>

{{-- MÔ TẢ TOUR --}}
<div class="mb-14">

<h2 class="text-2xl font-bold mb-4 text-slate-800">
Mô tả tour
</h2>

<div class="text-slate-700 leading-relaxed">
{!! nl2br(e($tour->description)) !!}
</div>

</div>

{{-- ALBUM ẢNH --}}
@if($tour->images && $tour->images->count())

<div class="mb-14">

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Hình ảnh tour
</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">

@foreach($tour->images as $image)

<img
src="{{ asset('storage/'.$image->image) }}"
class="h-40 w-full object-cover rounded-xl shadow hover:scale-105 transition">

@endforeach

</div>

</div>

@endif

{{-- NÚT QUAY LẠI --}}
<div class="text-center mt-10">

<a href="{{ url('/') }}"
class="bg-slate-800 hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-bold transition">

Quay lại trang chủ

</a>

</div>

</div>

@endsection