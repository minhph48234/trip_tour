<header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b">
    <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-600">TRAVEL<span class="text-orange-500">GO</span></a>
        
        <nav class="hidden md:flex space-x-8 font-medium">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Trang chủ</a>
            <a href="/destinations" class="hover:text-blue-600 transition">Điểm đến</a>
            <a href="/services" class="hover:text-blue-600 transition">Dịch vụ</a>
            <a href="/about" class="hover:text-blue-600 transition">Giới thiệu</a>
            <a href="/contact" class="hover:text-blue-600 transition">Liên hệ</a> 
        </nav>

        <div class="flex items-center gap-2">


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

             @auth

            <div class="relative group">

                <button class="flex items-center gap-2 font-semibold text-gray-700 hover:text-blue-600">

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
                        <button
                            class="w-full text-left px-4 py-3 hover:bg-gray-100 text-red-500">

                            Đăng xuất

                        </button>
                    </form>

                </div>

            </div>

            @endauth

            
        </div>
    </div>
</header>