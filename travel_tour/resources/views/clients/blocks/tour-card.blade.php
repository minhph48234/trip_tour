<div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100">

    {{-- ================= IMAGE ================= --}}
    <div class="relative overflow-hidden aspect-[4/3] bg-slate-200">

        @php
            if($tour->thumbnail){
                $displayImage = asset('storage/'.$tour->thumbnail);
            } elseif($tour->images->count()){
                $displayImage = asset('storage/'.$tour->images->first()->image);
            } else {
                $displayImage = 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?q=80&w=800';
            }
        @endphp

        <img src="{{ $displayImage }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            alt="{{ $tour->name }}">

        {{-- BADGE --}}
        <div class="absolute top-4 left-4 flex gap-2">

            <span class="bg-white/90 text-blue-600 px-3 py-1 rounded-full text-xs font-bold shadow">
                {{ $tour->duration ?? 'Không rõ thời gian' }}
            </span>

            @if($tour->views > 50)
                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                    Tour nổi bật
                </span>
            @endif

        </div>

    </div>


    {{-- ================= CONTENT ================= --}}
    <div class="p-6">

        {{-- DANH MỤC --}}
        <div class="text-sm text-orange-500 font-semibold mb-2 uppercase">
            {{ $tour->category->name ?? 'Du lịch' }}
        </div>

        {{-- TÊN TOUR --}}
        <h3 class="text-lg font-extrabold text-slate-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
            <a href="{{ route('client.tours.show',$tour->slug) }}">
                {{ $tour->name }}
            </a>
        </h3>

        {{-- ĐỊA ĐIỂM --}}
        <div class="text-sm text-gray-600 mb-2">
            <b>Khởi hành:</b> {{ $tour->departure_location ?? 'Đang cập nhật' }}
        </div>

        <div class="text-sm text-gray-600 mb-3">
            <b>Điểm đến:</b> {{ $tour->destination ?? 'Đang cập nhật' }}
        </div>

        {{-- THÔNG TIN TOUR --}}
        <div class="text-sm text-gray-600 mb-3 space-y-1">

            <div>
                <b>Phương tiện:</b> {{ $tour->transport ?? 'Đang cập nhật' }}
            </div>

            <div>
                <b>Số chỗ tối đa:</b> {{ $tour->max_people ?? 'Không giới hạn' }}
            </div>

        </div>

        {{-- ĐÁNH GIÁ --}}
        <div class="text-sm mb-3">

            <span class="font-semibold">
                Đánh giá:
            </span>

            <span class="text-yellow-600 font-bold">
                {{ $tour->reviews->avg('rating') ? number_format($tour->reviews->avg('rating'),1) : '5.0' }}
            </span>

            <span class="text-gray-400 text-xs">
                ({{ $tour->reviews->count() }} đánh giá)
            </span>

        </div>

        {{-- NGÀY KHỞI HÀNH --}}
        @if($tour->trips->count())
        <div class="mb-4">
            <span class="text-sm font-semibold text-gray-700">Ngày khởi hành:</span>

            <div class="flex flex-wrap gap-2 mt-2">
                @foreach($tour->trips->take(3) as $trip)
                    <span class="border px-2 py-1 rounded text-xs text-red-600">
                        {{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif


        {{-- GIÁ + ACTION --}}
        <div class="flex justify-between items-center pt-4 border-t">

            <div>
                <span class="text-slate-400 text-xs block">
                    Giá từ
                </span>

                <p class="text-xl font-black text-blue-600">
                    {{ number_format($tour->price,0,',','.') }} đ
                </p>

                @if($tour->child_price)
                <p class="text-xs text-gray-500">
                    Trẻ em: {{ number_format($tour->child_price,0,',','.') }} đ
                </p>
                @endif
            </div>

            <a href="{{ route('client.tours.show',$tour->slug) }}"
                class="bg-slate-900 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-600 transition">
                Xem chi tiết
            </a>

        </div>

    </div>

</div>