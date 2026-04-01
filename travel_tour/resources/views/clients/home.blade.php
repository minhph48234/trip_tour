@extends('layouts.client')

@section('title', 'Trang chủ - TravelGo')

@section('banner')
    @include('clients.blocks.banner')
@endsection

@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="grid grid-cols-12 gap-6">

        {{-- ================= FILTER ================= --}}
        <div class="col-span-12 lg:col-span-3">

            <form method="GET" action="{{ route('client.tours.search') }}"
                class="bg-white p-5 rounded-2xl shadow space-y-6">

                <h3 class="font-bold text-lg">Tìm kiếm tour</h3>

                <input type="text" name="keyword"
                    class="w-full border rounded-lg px-3 py-2"
                    placeholder="Tên tour...">

                <input type="text" name="departure_location"
                    class="w-full border rounded-lg px-3 py-2"
                    placeholder="Điểm khởi hành">

                <input type="text" name="destination"
                    class="w-full border rounded-lg px-3 py-2"
                    placeholder="Điểm đến">

                <select name="category_id"
                    class="w-full border rounded-lg px-3 py-2">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cate)
                        <option value="{{ $cate->id }}">
                            {{ $cate->name }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="start_date"
                    class="w-full border rounded-lg px-3 py-2">

                <input type="date" name="end_date"
                    class="w-full border rounded-lg px-3 py-2">

                <button class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold">
                    Tìm kiếm
                </button>

            </form>

        </div>


        {{-- ================= TOUR LIST ================= --}}
        <div class="col-span-12 lg:col-span-9">

            <h2 class="text-2xl font-bold mb-6">
                Danh sách tour nổi bật
            </h2>

            <div class="space-y-6">

                @forelse($featuredTours as $tour)

                @php
                    // IMAGE SAFE
                    if(!empty($tour->thumbnail)){
                        $img = asset('storage/'.$tour->thumbnail);
                    } elseif($tour->images && $tour->images->count()){
                        $img = asset('storage/'.$tour->images->first()->image);
                    } else {
                        $img = 'https://via.placeholder.com/600x400?text=No+Image';
                    }

                    // RATING SAFE
                    $rating = $tour->reviews ? $tour->reviews->avg('rating') : null;
                @endphp

                <div class="bg-white rounded-2xl shadow flex flex-col md:flex-row overflow-hidden">

                    {{-- IMAGE --}}
<div class="md:w-1/3 relative">

                        <img src="{{ $img }}"
                            class="h-full w-full object-cover"
                            onerror="this.src='https://via.placeholder.com/600x400?text=Image+Error'">

                        @if($tour->views > 50)
                        <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 text-xs rounded">
                            Tour nổi bật
                        </div>
                        @endif

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5 flex-1">

                        {{-- TÊN --}}
                        <h3 class="text-lg font-bold mb-2 text-blue-700">
                            <a href="{{ route('client.tours.show',$tour->slug) }}">
                                {{ $tour->name }}
                            </a>
                        </h3>

                        {{-- DANH MỤC --}}
                        <div class="text-sm text-orange-500 font-semibold mb-2">
                            {{ optional($tour->category)->name ?? 'Du lịch' }}
                        </div>

                        {{-- ĐỊA ĐIỂM --}}
                        <div class="text-sm text-gray-600 mb-2">
                            Khởi hành: {{ $tour->departure_location ?? '---' }}
                        </div>

                        <div class="text-sm text-gray-600 mb-2">
                            Điểm đến: {{ $tour->destination ?? '---' }}
                        </div>

                        {{-- THÔNG TIN --}}
                        <div class="text-sm text-gray-600 mb-2">
                            Thời gian: {{ $tour->duration ?? '---' }}
                        </div>

                        <div class="text-sm text-gray-600 mb-2">
                            Phương tiện: {{ $tour->transport ?? '---' }}
                        </div>

                        <div class="text-sm text-gray-600 mb-3">
                            Số chỗ tối đa: {{ $tour->max_people ?? '---' }}
                        </div>

                        {{-- ĐÁNH GIÁ --}}
                        <div class="text-sm mb-3">
                            Đánh giá:
                            <span class="text-yellow-600 font-bold">
                                {{ $rating ? number_format($rating,1) : '5.0' }}
                            </span>
                            ({{ $tour->reviews ? $tour->reviews->count() : 0 }} đánh giá)
                        </div>

                        {{-- NGÀY KHỞI HÀNH --}}
                        @if($tour->trips && $tour->trips->count())
                        <div class="mb-3">
                            <span class="text-sm font-semibold">Ngày khởi hành:</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($tour->trips->take(3) as $trip)
<span class="border px-2 py-1 rounded text-xs text-red-600">
                                        {{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- GIÁ --}}
                        <div class="flex justify-between items-center mt-4">

                            <div>
                                <div class="text-red-600 font-bold text-xl">
                                    {{ number_format($tour->price) }} đ
                                </div>

                                @if($tour->child_price)
                                <div class="text-xs text-gray-500">
                                    Trẻ em: {{ number_format($tour->child_price) }} đ
                                </div>
                                @endif
                            </div>

                            <a href="{{ route('client.tours.show',$tour->slug) }}"
                                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                                Xem chi tiết
                            </a>

                        </div>

                    </div>

                </div>

                @empty

                <div class="text-center py-20 text-gray-500">
                    Không có tour nào
                </div>

                @endforelse

            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $featuredTours->links() }}
            </div>

        </div>

    </div>

</div>

@endsection