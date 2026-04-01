@extends('layouts.client')

@section('title', 'Kết quả tìm kiếm - TravelGo')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-10">
    {{-- PHẦN TIÊU ĐỀ VÀ THANH TÌM KIẾM DÀN SANG PHẢI --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div class="w-full md:w-1/3">
            <h1 class="text-2xl font-bold text-slate-800">
                Kết quả cho: <span class="text-blue-600">"{{ request('keyword') }}"</span>
            </h1>
            <p class="text-slate-500 text-sm">Tìm thấy {{ $tours->total() }} tour phù hợp</p>
        </div>

        {{-- THANH TÌM KIẾM NHỎ GỌN ĐẨY SANG PHẢI --}}
        <div class="w-full md:w-2/3 flex justify-end">
            <form action="{{ route('client.tours.search') }}" method="GET" class="flex w-full max-w-2xl bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                <div class="flex-1 flex items-center px-4 py-2 border-r border-slate-100">
                    <i class="fas fa-search text-blue-500 mr-2"></i>
                    <input type="text" name="keyword" placeholder="Tìm tour khác..." 
                           class="w-full border-none focus:ring-0 text-sm text-slate-600"
                           value="{{ request('keyword') }}">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 font-bold transition">
                    TÌM
                </button>
            </form>
        </div>
    </div>

    <hr class="mb-10 border-slate-100">

    {{-- LƯỚI HIỂN THỊ KẾT QUẢ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($tours as $tour)
            <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100">
                <div class="relative overflow-hidden">
                    {{-- XỬ LÝ LỖI ẢNH: Nếu không có ảnh hoặc lỗi file, hiện ảnh dự phòng --}}
                    @php 
                        $mainImage = $tour->images->where('is_main', 1)->first() ?? $tour->images->first(); 
                    @endphp
                    
                    <img src="{{ $mainImage ? asset('storage/' . $mainImage->image) : 'https://img2.thuthuat123.com/uploads/2020/03/17/anh-vinh-ha-long-dep-nhat_115608633.jpg' }}" 
                         class="w-full h-56 object-cover group-hover:scale-110 transition duration-500" 
                         onerror="this.src='https://placehold.co/600x400?text=TravelGo+Tour'"
                         alt="{{ $tour->name }}">
                    
                    <div class="absolute top-4 left-4 bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md">
                        {{ $tour->duration }}
                    </div>
                </div>

                <div class="p-5">
                    <h3 class="text-lg font-bold mb-2 group-hover:text-blue-600 transition min-h-[50px]">
                        <a href="{{ route('booking.create', $tour->id) }}">{{ $tour->name }}</a>
                    </h3>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $tour->description }}</p>
                    
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-xl font-bold text-blue-600">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                        <a href="{{ route('booking.create', $tour->id) }}" class="text-blue-600 font-semibold hover:underline">
                            Chi tiết →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            {{-- TRẠNG THÁI TRỐNG --}}
            <div class="col-span-full text-center py-20">
                <i class="fas fa-search-minus text-6xl text-slate-200 mb-4"></i>
                <p class="text-slate-500 text-lg">Rất tiếc, chúng tôi không tìm thấy tour nào phù hợp.</p>
                <a href="{{ url('/') }}" class="text-blue-600 hover:underline mt-2 inline-block">Quay lại trang chủ</a>
            </div>
        @endforelse
    </div>

    {{-- PHÂN TRANG --}}
    <div class="mt-12">
        {{ $tours->appends(request()->query())->links() }}
    </div>
</section>
@endsection