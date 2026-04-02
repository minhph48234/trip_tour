@extends('layouts.client')

@section('title','Lịch sử thanh toán')

@section('content')

<div class="max-w-6xl mx-auto py-10 px-4">

<h1 class="text-2xl font-bold mb-6">
Lịch sử thanh toán
</h1>

@if($payments->count())

<div class="bg-white shadow-lg rounded-2xl overflow-hidden">

<table class="w-full text-center">

<thead class="bg-slate-100">

<tr>
<th class="p-3 border">Mã booking</th>
<th class="p-3 border">Số tiền</th>
<th class="p-3 border">Phương thức</th>
<th class="p-3 border">Loại</th>
<th class="p-3 border">Thanh toán</th>
<th class="p-3 border">Xác nhận</th> {{-- 🔥 thêm --}}
<th class="p-3 border">Ngày</th>
<th class="p-3 border">Chi tiết</th>
</tr>

</thead>

<tbody>

@foreach($payments as $payment)

<tr class="hover:bg-slate-50">

<td class="p-3 border">
{{ $payment->booking->booking_code }}
</td>

<td class="p-3 border text-red-600 font-bold">
{{ number_format($payment->amount) }} VNĐ
</td>

<td class="p-3 border">
{{ strtoupper($payment->method) }}
</td>

<td class="p-3 border">
@php
$typeText = match($payment->type){
    'deposit' => 'Thanh toán cọc',
    'final' => 'Thanh toán đầy đủ',
    'extra' => 'Thanh toán bổ sung',
    default => $payment->type
};
@endphp
{{ $typeText }}
</td>

{{-- ================= THANH TOÁN ================= --}}
<td class="p-3 border">
@php
$statusText = match($payment->status){
    'paid' => 'Đã thanh toán',
    'pending' => 'Chờ xử lý',
    'failed' => 'Thất bại',
    default => $payment->status
};

$statusColor = match($payment->status){
    'paid' => 'bg-green-100 text-green-700',
    'pending' => 'bg-yellow-100 text-yellow-700',
    'failed' => 'bg-red-100 text-red-700',
    default => 'bg-gray-100 text-gray-700'
};
@endphp

<span class="px-3 py-1 rounded-lg font-semibold {{ $statusColor }}">
{{ $statusText }}
</span>
</td>

{{-- ================= ADMIN CONFIRM ================= --}}
<td class="p-3 border">
@php
$adminText = match($payment->admin_confirm_status){
    'confirmed' => 'Đã xác nhận',
    default => 'Chờ xác nhận'
};

$adminColor = match($payment->admin_confirm_status){
    'confirmed' => 'bg-green-100 text-green-700',
    default => 'bg-yellow-100 text-yellow-700'
};
@endphp

<span class="px-3 py-1 rounded-lg font-semibold {{ $adminColor }}">
{{ $adminText }}
</span>
</td>

<td class="p-3 border">
{{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-' }}
</td>

<td class="p-3 border">

<a href="{{ route('payment.show', $payment->id) }}"
class="text-blue-600 hover:underline font-semibold">

Xem hoá đơn

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-6">
{{ $payments->links() }}
</div>

@else

<p class="text-gray-500">
Bạn chưa có giao dịch nào.
</p>

@endif

</div>

@endsection