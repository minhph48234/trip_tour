<header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b">
    <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
            TRAVEL<span class="text-orange-500">GO</span>
        </a>

        {{-- MENU --}}
        <nav class="hidden md:flex space-x-8 font-medium">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Trang chủ</a>

            <a href="{{ route('destinations') }}" 
               class="hover:text-blue-600 transition">
               Điểm đến
            </a>

            <a href="{{ route('service') }}" 
               class="hover:text-blue-600 transition">
               Dịch vụ
            </a>

            <a href="{{ route('about') }}" 
               class="hover:text-blue-600 transition">
               Giới thiệu
            </a>

            <a href="{{ route('contact') }}" 
               class="hover:text-blue-600 transition">
               Liên hệ
            </a> 
        </nav>

        {{-- AUTH --}}
        <div class="flex items-center gap-3">

            {{-- CHƯA LOGIN --}}
            @guest
                <a href="{{ route('login') }}"
                   class="px-5 py-2 rounded-full border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold transition">
                    Đăng nhập
                </a>

                <a href="{{ route('register') }}"
                   class="px-5 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow-md transition">
                    Đăng ký
                </a>
            @endguest

            {{-- ĐÃ LOGIN --}}
            @auth

                {{-- 🔔 NOTIFICATION --}}
                @php
                    $notifications = Auth::user()->notifications ?? collect();
                    $unreadCount = Auth::user()->unreadNotifications->count() ?? 0;
                @endphp

                <div class="relative">

                    <button id="bellBtn" 
                        class="relative p-2 rounded-full hover:bg-gray-100 transition">

                        🔔

                        @if($unreadCount > 0)
                            <span id="notiBadge"
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>

                    {{-- DROPDOWN --}}
                    <div id="notiBox"
                        class="hidden absolute right-0 mt-3 w-80 bg-white border rounded-xl shadow-lg z-50">

                        <div class="p-3 border-b font-semibold text-gray-700">
                            Thông báo
                        </div>

                        <div class="max-h-64 overflow-y-auto">

                            @forelse($notifications->take(5) as $noti)
                                <div class="p-3 border-b text-sm hover:bg-gray-50">

                                    {{-- nội dung --}}
                                    <div class="text-gray-700">
                                        {{ $noti->data['message'] ?? '' }}
                                    </div>

                                    {{-- số tiền --}}
                                    @if(isset($noti->data['amount']))
                                        <div class="text-red-500 font-semibold mt-1">
                                            {{ number_format($noti->data['amount']) }} đ
                                        </div>
                                    @endif

                                    {{-- link --}}
                                    @if(isset($noti->data['booking_id']))
                                        <a href="{{ route('booking.show', $noti->data['booking_id']) }}"
                                           class="text-blue-500 text-xs mt-1 inline-block">
                                           Xem chi tiết
                                        </a>
                                    @endif

                                </div>
                            @empty
                                <div class="p-3 text-gray-500 text-center">
                                    Không có thông báo
                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

                {{-- USER --}}
                <div class="relative group">

                    <button class="flex items-center gap-2 px-3 py-2 rounded-lg 
                        font-semibold text-gray-700 
                        hover:bg-blue-100 hover:text-blue-700 
                        transition duration-200 cursor-pointer">

                        {{-- Avatar --}}
                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center">
                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                        </div>

                        {{ Auth::user()->name }}

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- DROPDOWN --}}
                    <div class="absolute right-0 mt-3 w-48 bg-white border rounded-xl shadow-lg hidden group-hover:block">

                        <a href="{{ route('booking.history') }}"
                           class="block px-4 py-3 hover:bg-gray-100">
                            Lịch sử đặt tour
                        </a>

                        <a href="{{ route('payment.history') }}"
                           class="block px-4 py-3 hover:bg-gray-100">
                            Lịch sử thanh toán
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="w-full text-left px-4 py-3 hover:bg-gray-100 text-red-500">
                                Đăng xuất
                            </button>
                        </form>

                    </div>

                </div>

            @endauth

        </div>
    </div>
</header>

{{-- JS --}}
<script>
document.getElementById('bellBtn')?.addEventListener('click', function () {

    let box = document.getElementById('notiBox');
    box.classList.toggle('hidden');

    fetch("{{ route('user.notifications.read') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    }).then(() => {
        let badge = document.getElementById('notiBadge');
        if (badge) badge.remove();
    });

});
</script>