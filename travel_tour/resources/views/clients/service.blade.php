@extends('layouts.client')

@section('title', 'Dịch vụ - TravelGo')

@section('banner')
    @include('clients.blocks.banner')
@endsection

@section('content')

{{-- GIỚI THIỆU DỊCH VỤ --}}
<section class="max-w-7xl mx-auto px-4 py-16 text-center">
    <h2 class="text-3xl font-bold text-slate-800 uppercase mb-4">
        Dịch vụ của chúng tôi
    </h2>
    <p class="text-gray-600 max-w-2xl mx-auto">
        TravelGo cung cấp các dịch vụ du lịch trọn gói, mang đến trải nghiệm tuyệt vời và tiện lợi nhất cho khách hàng.
    </p>
</section>

{{-- DANH SÁCH DỊCH VỤ --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        {{-- Dịch vụ 1 --}}
        <div class="bg-white shadow-md rounded-xl p-6 text-center hover:shadow-xl transition">
            <div class="text-4xl mb-4">✈️</div>
            <h3 class="text-xl font-semibold mb-2">Đặt tour du lịch</h3>
            <p class="text-gray-600">
                Cung cấp đa dạng tour trong và ngoài nước với giá tốt nhất.
            </p>
        </div>

        {{-- Dịch vụ 2 --}}
        <div class="bg-white shadow-md rounded-xl p-6 text-center hover:shadow-xl transition">
            <div class="text-4xl mb-4">🚗</div>
            <h3 class="text-xl font-semibold mb-2">Thuê xe du lịch</h3>
            <p class="text-gray-600">
                Dịch vụ thuê xe tiện lợi, an toàn, phù hợp mọi nhu cầu.
            </p>
        </div>

        {{-- Dịch vụ 3 --}}
        <div class="bg-white shadow-md rounded-xl p-6 text-center hover:shadow-xl transition">
            <div class="text-4xl mb-4">🏨</div>
            <h3 class="text-xl font-semibold mb-2">Đặt khách sạn</h3>
            <p class="text-gray-600">
                Hệ thống khách sạn đa dạng, từ bình dân đến cao cấp.
            </p>
        </div>

        {{-- Dịch vụ 4 --}}
        <div class="bg-white shadow-md rounded-xl p-6 text-center hover:shadow-xl transition">
            <div class="text-4xl mb-4">🧭</div>
            <h3 class="text-xl font-semibold mb-2">Hướng dẫn viên</h3>
            <p class="text-gray-600">
                Đội ngũ hướng dẫn viên chuyên nghiệp, nhiệt tình.
            </p>
        </div>

        {{-- Dịch vụ 5 --}}
        <div class="bg-white shadow-md rounded-xl p-6 text-center hover:shadow-xl transition">
            <div class="text-4xl mb-4">🎫</div>
            <h3 class="text-xl font-semibold mb-2">Vé máy bay</h3>
            <p class="text-gray-600">
                Đặt vé nhanh chóng, giá ưu đãi từ nhiều hãng hàng không.
            </p>
        </div>

        {{-- Dịch vụ 6 --}}
        <div class="bg-white shadow-md rounded-xl p-6 text-center hover:shadow-xl transition">
            <div class="text-4xl mb-4">💼</div>
            <h3 class="text-xl font-semibold mb-2">Tư vấn du lịch</h3>
            <p class="text-gray-600">
                Tư vấn lịch trình phù hợp với nhu cầu và ngân sách của bạn.
            </p>
        </div>

    </div>

</section>

{{-- LÝ DO CHỌN CHÚNG TÔI --}}
<section class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-slate-800 mb-10">
            Vì sao chọn TravelGo?
        </h2>

        <div class="grid md:grid-cols-3 gap-10">

            <div>
                <h3 class="font-semibold text-lg mb-2">Giá tốt nhất</h3>
                <p class="text-gray-600">Cam kết giá cạnh tranh và nhiều ưu đãi.</p>
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-2">Chất lượng đảm bảo</h3>
                <p class="text-gray-600">Dịch vụ chuyên nghiệp, trải nghiệm tuyệt vời.</p>
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-2">Hỗ trợ 24/7</h3>
                <p class="text-gray-600">Luôn sẵn sàng hỗ trợ khách hàng mọi lúc.</p>
            </div>

        </div>
    </div>
</section>

@endsection