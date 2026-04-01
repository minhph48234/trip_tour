@extends('layouts.client')

@section('title', 'Điểm đến - TravelGo')

@section('banner')
    @include('clients.blocks.banner')
@endsection

@section('content')

{{-- TIÊU ĐỀ --}}
<section class="max-w-7xl mx-auto px-4 py-16 text-center">
    <h2 class="text-3xl font-bold text-slate-800 uppercase mb-4">
        Khám phá điểm đến
    </h2>
    <p class="text-gray-600 max-w-2xl mx-auto">
        Cùng TravelGo khám phá những địa điểm du lịch hấp dẫn với nhiều trải nghiệm tuyệt vời.
    </p>
</section>

{{-- DANH MỤC --}}
<section class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-wrap gap-4 justify-center">

        @foreach($categories as $category)
            <a href="#"
               class="px-5 py-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition">
                {{ $category->name }}
            </a>
        @endforeach

    </div>
</section>

{{-- TOUR NỔI BẬT --}}
<section class="max-w-7xl mx-auto px-4 py-16">

    <div class="flex justify-between items-center mb-10">
        <h2 class="text-2xl font-bold text-slate-800 uppercase">
            Tour nổi bật
        </h2>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($featuredTours as $tour)
            @include('clients.blocks.tour-card')
        @empty
            <p class="col-span-full text-center">Không có tour</p>
        @endforelse

    </div>

</section>

{{-- TOUR MỚI --}}
<section class="max-w-7xl mx-auto px-4 py-16 bg-slate-50">

    <div class="mb-10">
        <h2 class="text-2xl font-bold text-slate-800 uppercase">
            Tour mới nhất
        </h2>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($latestTours as $tour)
            @include('clients.blocks.tour-card')
        @empty
            <p class="col-span-full text-center">Không có tour</p>
        @endforelse

    </div>

</section>

{{-- TOUR GIÁ RẺ --}}
<section class="max-w-7xl mx-auto px-4 py-16">

    <div class="mb-10">
        <h2 class="text-2xl font-bold text-slate-800 uppercase">
            Tour giá rẻ
        </h2>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($cheapTours as $tour)
            @include('clients.blocks.tour-card')
        @empty
            <p class="col-span-full text-center">Không có tour</p>
        @endforelse

    </div>

</section>

{{-- TOUR HOT --}}
<section class="max-w-7xl mx-auto px-4 py-16 bg-slate-50">

    <div class="mb-10">
        <h2 class="text-2xl font-bold text-slate-800 uppercase">
            Tour hot
        </h2>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($hotTours as $tour)
            @include('clients.blocks.tour-card')
        @empty
            <p class="col-span-full text-center">Không có tour</p>
        @endforelse

    </div>

</section>

@endsection