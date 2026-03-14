@extends('layouts.client')

@section('title', 'Trang chủ - TravelGo')

@section('banner')
    @include('clients.blocks.banner')
@endsection

@section('content')


{{-- TOUR NỔI BẬT --}}
<section class="max-w-7xl mx-auto px-4 py-16">

    <div class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-bold text-slate-800 uppercase">
            Tour nổi bật
        </h2>

        <a href="{{ route('client.tours.featured') }}"
        class="text-blue-600 font-semibold hover:underline">
            Xem tất cả →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($featuredTours as $tour)

        @include('clients.blocks.tour-card')

        @empty

        <div class="col-span-full text-center py-20">
            Không có tour nổi bật
        </div>

        @endforelse

    </div>

</section>



{{-- TOUR MỚI NHẤT --}}
<section class="max-w-7xl mx-auto px-4 py-16 bg-slate-50">

    <div class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-bold text-slate-800 uppercase">
            Tour mới nhất
        </h2>

        <a href="{{ route('client.tours.latest') }}"
            class="text-blue-600 font-semibold hover:underline">
            Xem tất cả →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($latestTours as $tour)

        @include('clients.blocks.tour-card')

        @empty

        <div class="col-span-full text-center py-20">
            Không có tour mới
        </div>

        @endforelse

    </div>

</section>



{{-- TOUR GIÁ RẺ --}}
<section class="max-w-7xl mx-auto px-4 py-16">

    <div class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-bold text-slate-800 uppercase">
            Tour giá rẻ
        </h2>

        <a href="{{ route('client.tours.latest') }}"
        class="text-blue-600 font-semibold hover:underline">
            Xem tất cả →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($cheapTours as $tour)

        @include('clients.blocks.tour-card')

        @empty

        <div class="col-span-full text-center py-20">
            Không có tour giá rẻ
        </div>

        @endforelse

    </div>

</section>



{{-- TOUR HOT --}}
<section class="max-w-7xl mx-auto px-4 py-16 bg-slate-50">

    <div class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-bold text-slate-800 uppercase">
            Tour hot
        </h2>

        <a href="{{ route('client.tours.cheap') }}"
        class="text-blue-600 font-semibold hover:underline">
            Xem tất cả →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($hotTours as $tour)

        @include('clients.blocks.tour-card')

        @empty

        <div class="col-span-full text-center py-20">
            Không có tour hot
        </div>

        @endforelse

    </div>

</section>


@endsection