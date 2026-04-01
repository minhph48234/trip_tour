@extends('layouts.client')

@section('title', $tour->name)

@section('content')

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

{{-- TÊN --}}
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


{{-- HIGHLIGHT --}}
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

<h3 class="font-bold text-blue-600 mb-4">
Ngày {{ $day }}
</h3>

@foreach($items as $item)

<div class="flex gap-4 mb-3">

<div class="w-3 h-3 bg-blue-600 rounded-full mt-2"></div>

<div>
    <p class="font-semibold">
        {{ $item->title }}
    </p>

    <p class="text-sm text-gray-500">
        {{ $item->description }}
    </p>
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

<p class="text-yellow-500">
⭐ {{ $review->rating }}/5
</p>

<p>{{ $review->comment }}</p>

</div>

@empty

<p class="text-gray-500">Chưa có đánh giá</p>

@endforelse

</div>

</div>


{{-- ================= RIGHT (BOOKING BOX) ================= --}}
<div>

<div class="border rounded-xl p-5 shadow sticky top-5">

<p class="text-gray-500">Giá từ</p>

<h2 class="text-2xl font-bold text-red-500 mb-4">
{{ number_format($tour->price) }} VNĐ
</h2>


{{-- TRIPS --}}
<h3 class="font-semibold mb-2">Ngày khởi hành</h3>

<select id="tripSelect" class="w-full border p-2 rounded mb-4">

@foreach($tour->trips as $trip)
<option value="{{ $trip->id }}">
{{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}
- còn {{ $trip->max_people - $trip->current_people }} chỗ
</option>
@endforeach

</select>

<a id="bookingBtn"
   href="{{ $tour->trips->first() ? route('booking.create',$tour->trips->first()->id) : '#' }}"
   class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">

Đặt ngay

</a>

</div>

</div>

</div>


{{-- ================= JS ================= --}}
<script>
document.getElementById('tripSelect')?.addEventListener('change', function () {
    let tripId = this.value;
    let url = "{{ route('booking.create', ':id') }}".replace(':id', tripId);
    document.getElementById('bookingBtn').href = url;
});
</script>

@endsection