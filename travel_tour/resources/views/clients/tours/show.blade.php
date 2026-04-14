@extends('layouts.client')

@section('title', $tour->name)

@section('content')

@php
use Carbon\Carbon;
@endphp

<div class="max-w-7xl mx-auto px-4 py-10">

{{-- ====================== GALLERY ====================== --}}
<div class="grid md:grid-cols-3 gap-4 mb-10">

    <div class="md:col-span-2">
        <img src="{{ asset('storage/'.$tour->thumbnail) }}"
             class="w-full h-[400px] object-cover rounded-2xl shadow">
    </div>

    <div class="grid grid-rows-2 gap-4">
        @foreach($tour->images->take(2) as $img)
            <img src="{{ asset('storage/'.$img->image) }}"
                 class="w-full h-full object-cover rounded-xl">
        @endforeach
    </div>

</div>


<div class="grid md:grid-cols-3 gap-10">

{{-- ================= LEFT ================= --}}
<div class="md:col-span-2">

<h1 class="text-3xl font-bold mb-3">
    {{ $tour->name }}
</h1>

<p class="text-gray-500 mb-4">
    {{ $tour->departure_location }} → {{ $tour->destination }}
</p>

<div class="flex gap-5 text-sm mb-6 text-gray-600">
    <span>⏱ {{ $tour->duration }}</span>
    <span>🚗 {{ $tour->transport }}</span>
    <span>👥 {{ $tour->max_people }} khách</span>
</div>

{{-- MÔ TẢ --}}
<div class="mb-10">
    <h2 class="text-xl font-bold mb-3">Giới thiệu</h2>
    <p class="text-gray-700 leading-relaxed">
        {!! nl2br(e($tour->description)) !!}
    </p>
</div>

@if($tour->highlight)
<div class="mb-10">
    <h2 class="text-xl font-bold mb-3">Điểm nổi bật</h2>
    <p class="text-gray-700">
        {!! nl2br(e($tour->highlight)) !!}
    </p>
</div>
@endif

{{-- ====================== LỊCH TRÌNH ====================== --}}
@if($tour->itineraries->count())

<div class="mb-12">
<h2 class="text-xl font-bold mb-6">📅 Lịch trình tour</h2>

@foreach($tour->itineraries->groupBy('day') as $day => $items)

<div class="mb-6 border rounded-xl p-5 shadow-sm">
<h3 class="font-bold text-blue-600 mb-4">Ngày {{ $day }}</h3>

@foreach($items as $item)
<div class="flex gap-4 mb-3">
<div class="w-3 h-3 bg-blue-600 rounded-full mt-2"></div>
<div>
    <p class="font-semibold">{{ $item->title }}</p>
    <p class="text-sm text-gray-500">{{ $item->description }}</p>
</div>
</div>
@endforeach

</div>
@endforeach
</div>
@endif

{{-- ====================== ALBUM ====================== --}}
@if($tour->images->count())

<div class="mb-12">
<h2 class="text-xl font-bold mb-6">Hình ảnh</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
@foreach($tour->images as $img)
<img src="{{ asset('storage/'.$img->image) }}"
     class="h-40 w-full object-cover rounded-xl hover:scale-105 transition">
@endforeach
</div>

</div>
@endif

{{-- ====================== REVIEW ====================== --}}
<div class="mb-12">

<h2 class="text-xl font-bold mb-6">Đánh giá</h2>

@forelse($tour->reviews as $review)
<div class="bg-white p-4 rounded-xl shadow mb-3">

<div class="flex items-center mb-2">
<img src="{{ $review->user->avatar 
? asset('storage/'.$review->user->avatar) 
: 'https://via.placeholder.com/40' }}"
class="w-10 h-10 rounded-full mr-3">

<b>{{ $review->user->name }}</b>
</div>

<p class="text-yellow-500">⭐ {{ $review->rating }}/5</p>
<p>{{ $review->comment }}</p>

</div>
@empty
<p class="text-gray-500">Chưa có đánh giá</p>
@endforelse

</div>

</div>


{{-- ================= RIGHT ================= --}}
<div>

<div class="border rounded-xl p-5 shadow sticky top-5">

<p class="text-gray-500">Giá từ</p>

<h2 class="text-2xl font-bold text-red-500 mb-4">
{{ number_format($tour->price) }} VNĐ
</h2>

<h3 class="font-semibold mb-2">Ngày khởi hành</h3>

<select id="tripSelect" class="w-full border p-2 rounded mb-4">

@foreach($tour->trips as $trip)

@php
    $today = Carbon::today();
    $startDate = Carbon::parse($trip->start_date);
    $daysLeft = $today->diffInDays($startDate, false);

    $isExpired = $startDate->isPast();
    $isClose = $daysLeft <= 2;
    $isClosed = $trip->status !== 'open';
    $isFull = ($trip->max_people - $trip->current_people) <= 0;

    $disabled = $isExpired || $isClose || $isClosed || $isFull;
@endphp

<option value="{{ $trip->id }}" {{ $disabled ? 'disabled' : '' }}>
    {{ $startDate->format('d/m/Y') }}
    - còn {{ max(0, $trip->max_people - $trip->current_people) }} chỗ

    @if($isExpired)
        (Hết hạn)
    @elseif($isClose)
        (Sắp khởi hành)
    @elseif($isFull)
        (Đã đầy)
    @elseif($isClosed)
        (Đã đóng)
    @endif
</option>

@endforeach

</select>

@php
    $firstValidTrip = $tour->trips->first(function($trip){
        $today = \Carbon\Carbon::today();
        $startDate = \Carbon\Carbon::parse($trip->start_date);
        $daysLeft = $today->diffInDays($startDate, false);

        return $trip->status === 'open'
            && !$startDate->isPast()
            && $daysLeft > 2
            && ($trip->max_people - $trip->current_people) > 0;
    });
@endphp

<a id="bookingBtn"
   href="{{ $firstValidTrip ? route('booking.create',$firstValidTrip->id) : '#' }}"
   class="block text-center py-2 rounded-lg
   {{ $firstValidTrip ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-400 text-white cursor-not-allowed' }}">

{{ $firstValidTrip ? 'Đặt ngay' : 'Không còn lịch phù hợp' }}

</a>

</div>

</div>

</div>


{{-- ================= JS ================= --}}
<script>
document.getElementById('tripSelect')?.addEventListener('change', function () {
    let selectedOption = this.options[this.selectedIndex];

    if (selectedOption.disabled) return;

    let tripId = this.value;
    let url = "{{ route('booking.create', ':id') }}".replace(':id', tripId);

    let btn = document.getElementById('bookingBtn');
    btn.href = url;
    btn.classList.remove('bg-gray-400','cursor-not-allowed');
    btn.classList.add('bg-blue-600','hover:bg-blue-700');
    btn.innerText = 'Đặt ngay';
});
</script>

@endsection