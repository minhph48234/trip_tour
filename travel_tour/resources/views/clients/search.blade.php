@extends('layouts.client')

@section('title','Kết quả tìm kiếm')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    <h2 class="text-2xl font-bold mb-6">
        🔍 Kết quả tìm kiếm tour
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($tours as $tour)

            @include('clients.blocks.tour-card')

        @empty

            <div class="col-span-full text-center py-20 text-gray-500">
                Không tìm thấy tour phù hợp
            </div>

        @endforelse

    </div>

    <div class="mt-6">
        {{ $tours->links() }}
    </div>

</div>

@endsection