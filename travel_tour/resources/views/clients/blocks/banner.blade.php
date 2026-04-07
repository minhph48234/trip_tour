<section class="relative h-[500px] flex items-center justify-center text-white">
    
    {{-- BACKGROUND --}}
    <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=2073"
         class="absolute inset-0 w-full h-full object-cover brightness-50"
         alt="Banner">

    <div class="relative z-10 text-center space-y-6 px-4">
        <h2 class="text-5xl font-bold leading-tight">
            Khám Phá Thế Giới Theo Cách Của Bạn
        </h2>
        <p class="text-xl opacity-90">
            Hàng ngàn tour du lịch giá tốt đang chờ đón bạn
        </p>

        {{-- SEARCH BAR --}}
        <div class="max-w-6xl mx-auto px-4 -mt-12 relative z-20">
            <div class="bg-white p-4 md:p-6 rounded-3xl shadow-2xl border border-slate-100">

                <form action="{{ route('client.tours.search') }}"
                      method="GET"
                      class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                    {{-- KEYWORD --}}
                    <div class="md:col-span-4 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-2xl border border-transparent focus-within:border-blue-500 transition">
                        <i class="fas fa-search text-blue-600"></i>
                        <div class="flex-1">
                            <label class="block text-[10px] uppercase font-bold text-slate-400">
                                Bạn muốn đi đâu?
                            </label>
                            <input type="text"
                                   name="keyword"
                                   placeholder="Tìm tên tour..."
                                   class="w-full bg-transparent border-none p-0 focus:ring-0 text-slate-700 placeholder-slate-400 font-medium"
                                   value="{{ request('keyword') }}">
                        </div>
                    </div>

                    {{-- DATE --}}
                    <div class="md:col-span-3 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-2xl border border-transparent focus-within:border-blue-500 transition">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                        <div class="flex-1">
                            <label class="block text-[10px] uppercase font-bold text-slate-400">
                                Ngày đi
                            </label>
                            <input type="date"
                                   name="departure_date"
                                   class="w-full bg-transparent border-none p-0 focus:ring-0 text-slate-700 font-medium cursor-pointer"
                                   value="{{ request('departure_date') }}">
                        </div>
                    </div>

                    {{-- CATEGORY --}}
                    <div class="md:col-span-3 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-2xl border border-transparent focus-within:border-blue-500 transition">
                        <i class="fas fa-th-large text-blue-600"></i>
                        <div class="flex-1">
                            <label class="block text-[10px] uppercase font-bold text-slate-400">
                                Loại hình
                            </label>

                            <select name="category_id"
                                    class="w-full bg-transparent border-none p-0 focus:ring-0 text-slate-700 font-medium cursor-pointer appearance-none">

                                <option value="">Tất cả danh mục</option>

                                {{-- FIX LỖI categories --}}
                                @if(!empty($categories) && count($categories) > 0)

                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach

                                @else
                                    <option disabled>Không có danh mục</option>
                                @endif

                            </select>
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="md:col-span-2">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            <span>TÌM</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>