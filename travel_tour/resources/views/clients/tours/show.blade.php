@extends('layouts.client')

@section('title', $tour->name)

@section('content')

@php
use Illuminate\Support\Str;

/* ======================
ẢNH ĐẠI DIỆN TOUR
====================== */
$displayUrl = null;

if ($tour->thumbnail) {

    if (Str::startsWith($tour->thumbnail,['http://','https://'])) {
        $displayUrl = $tour->thumbnail;
    }
    elseif (file_exists(public_path('storage/'.$tour->thumbnail))) {
        $displayUrl = asset('storage/'.$tour->thumbnail);
    }
}

if(!$displayUrl){
    $displayUrl = 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?q=80&w=1200';
}

@endphp


<div class="max-w-7xl mx-auto py-10 px-4">

{{-- ======================
ẢNH TOUR
====================== --}}
<div class="mb-10">

<img src="{{ $displayUrl }}"
class="w-full h-[420px] object-cover rounded-2xl shadow-lg">

</div>


{{-- ======================
TÊN + GIÁ
====================== --}}
<div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">

<h1 class="text-3xl font-bold text-slate-800">
{{ $tour->name }}
</h1>

<div class="text-3xl font-black text-red-600 mt-4 md:mt-0">
{{ number_format($tour->price) }} VNĐ
</div>

<div class="text-3xl font-black text-red-600 mt-4 md:mt-0">
@if($tour->trips->first())

<a href="{{ route('booking.create',$tour->trips->first()->id) }}"
class="btn btn-primary">

Đặt tour

</a>

@endif
</div>
</div>


{{-- ======================
THÔNG TIN TOUR
====================== --}}
<div class="grid md:grid-cols-2 gap-10 mb-12">

<div class="space-y-3 text-slate-700">

<p><b>Danh mục:</b> {{ $tour->category->name ?? 'Chưa phân loại' }}</p>

<p><b>Thời gian:</b> {{ $tour->duration }}</p>

<p><b>Điểm đi:</b> {{ $tour->departure_location }}</p>

<p><b>Điểm đến:</b> {{ $tour->destination }}</p>

<p><b>Phương tiện:</b> {{ $tour->transport }}</p>

<p><b>Số khách tối đa:</b> {{ $tour->max_people }}</p>

@if($tour->child_price)
<p><b>Giá trẻ em:</b> {{ number_format($tour->child_price) }} VNĐ</p>
@endif

</div>


<div class="flex items-center justify-start md:justify-end">

@if($tour->trips->first())

<a href="{{ route('booking.create',$tour->trips->first()->id) }}"
class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl text-lg font-bold shadow-lg transition">

ĐẶT TOUR NGAY

</a>

@endif

</div>

</div>



{{-- ======================
MÔ TẢ TOUR
====================== --}}
<div class="mb-14">

<h2 class="text-2xl font-bold mb-4 text-slate-800">
Mô tả tour
</h2>

<div class="text-slate-700 leading-relaxed">
{!! nl2br(e($tour->description)) !!}
</div>

</div>



{{-- ======================
ĐIỂM NỔI BẬT
====================== --}}
@if($tour->highlight)

<div class="mb-14">

<h2 class="text-2xl font-bold mb-4 text-slate-800">
Điểm nổi bật
</h2>

<div class="text-slate-700">
{!! nl2br(e($tour->highlight)) !!}
</div>

</div>

@endif



{{-- ======================
ALBUM ẢNH
====================== --}}
@if($tour->images->count())

<div class="mb-14">

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Hình ảnh tour
</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">

@foreach($tour->images as $img)

<img
src="{{ asset('storage/'.$img->image) }}"
class="h-40 w-full object-cover rounded-xl shadow hover:scale-105 transition">

@endforeach

</div>

</div>

@endif



{{-- ======================
LỊCH TRÌNH TOUR
====================== --}}
@if($tour->itineraries->count())

<div class="mb-16">

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Lịch trình
</h2>

<div class="space-y-4">

@foreach($tour->itineraries as $item)

<div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-600">

<h3 class="font-bold mb-2">
Ngày {{ $item->day_number }}: {{ $item->title }}
</h3>

<div class="text-slate-600">
{!! $item->description !!}
</div>

</div>

@endforeach

</div>

</div>

@endif



{{-- ======================
LỊCH KHỞI HÀNH
====================== --}}
<div class="mb-16">

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Lịch khởi hành
</h2>

@if($tour->trips->count())

<div class="overflow-x-auto">

<table class="w-full border rounded-xl overflow-hidden">

<thead>

<tr class="bg-slate-100 text-center">

<th class="p-3 border">Ngày đi</th>
<th class="p-3 border">Ngày về</th>
<th class="p-3 border">Chỗ còn</th>
<th class="p-3 border"></th>

</tr>

</thead>

<tbody>

@foreach($tour->trips as $trip)

<tr class="text-center hover:bg-slate-50">

<td class="p-3 border">
{{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}
</td>

<td class="p-3 border">
{{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}
</td>

<td class="p-3 border">

{{ $trip->max_people - $trip->current_people }}

</td>

<td class="p-3 border">

<a href="{{ route('booking.create',$trip->id) }}"
class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

Đặt ngay

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@else

<p class="text-slate-500">
Hiện chưa có lịch khởi hành
</p>

@endif

</div>



{{-- ======================
ĐÁNH GIÁ
====================== --}}
<div class="mb-16">

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Đánh giá khách hàng
</h2>

@forelse($tour->reviews as $review)

<div class="bg-white p-5 rounded-xl shadow mb-4">

<div class="flex items-center mb-2">

<img
src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : 'https://via.placeholder.com/40' }}"
class="w-10 h-10 rounded-full mr-3">

<b>{{ $review->user->name }}</b>

</div>

<p class="text-yellow-500">
⭐ {{ $review->rating }}/5
</p>

<p class="text-slate-700">
{{ $review->comment }}
</p>

</div>

@empty

<p class="text-slate-500">
Chưa có đánh giá
</p>

@endforelse

</div>



{{-- ======================
TOUR LIÊN QUAN
====================== --}}
@if($relatedTours->count())

<div>

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Tour liên quan
</h2>

<div class="grid md:grid-cols-4 gap-6">

@foreach($relatedTours as $item)

<div class="bg-white rounded-xl shadow hover:shadow-lg transition">

<img
src="{{ asset('storage/'.$item->thumbnail) }}"
class="h-40 w-full object-cover rounded-t-xl">

<div class="p-4">

<h3 class="font-bold text-sm mb-2 line-clamp-2">
{{ $item->name }}
</h3>

<p class="text-red-600 font-bold mb-3">
{{ number_format($item->price) }} VNĐ
</p>

<a href="{{ route('client.tours.show',$item->slug) }}"
class="text-blue-600 font-semibold">

Xem chi tiết →

</a>

</div>

</div>

@endforeach

</div>

</div>

@endif

</div>

@endsection