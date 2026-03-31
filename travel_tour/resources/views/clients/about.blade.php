@extends('layouts.client')

@section('title', 'Giới thiệu - TravelGo')

@section('banner')
    @include('clients.blocks.banner')
@endsection

@section('content')

{{-- GIỚI THIỆU --}}
<section class="max-w-7xl mx-auto px-4 py-16 text-center">
    <h2 class="text-3xl font-bold text-slate-800 uppercase mb-4">
        Giới thiệu về TravelGo
    </h2>
    <p class="text-gray-600 max-w-3xl mx-auto">
        TravelGo là nền tảng du lịch trực tuyến chuyên cung cấp các tour du lịch chất lượng cao 
        trong và ngoài nước. Chúng tôi mang đến cho khách hàng những trải nghiệm tuyệt vời, 
        tiện lợi và đáng nhớ trong mỗi chuyến đi.
    </p>
</section>

{{-- SỨ MỆNH - TẦM NHÌN --}}
<section class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-10">

        <div class="bg-white p-8 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">🎯 Sứ mệnh</h3>
            <p class="text-gray-600">
                Mang đến cho khách hàng những hành trình trọn vẹn, an toàn và đầy cảm hứng. 
                TravelGo luôn đặt trải nghiệm khách hàng lên hàng đầu.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">🌍 Tầm nhìn</h3>
            <p class="text-gray-600">
                Trở thành nền tảng du lịch hàng đầu Việt Nam, kết nối mọi người với những điểm đến tuyệt vời trên toàn thế giới.
            </p>
        </div>

    </div>
</section>

{{-- GIÁ TRỊ CỐT LÕI --}}
<section class="max-w-7xl mx-auto px-4 py-16 text-center">
    <h2 class="text-3xl font-bold text-slate-800 mb-10">
        Giá trị cốt lõi
    </h2>

    <div class="grid md:grid-cols-3 gap-10">

        <div>
            <h3 class="font-semibold text-lg mb-2">Uy tín</h3>
            <p class="text-gray-600">Cam kết mang đến dịch vụ đáng tin cậy.</p>
        </div>

        <div>
            <h3 class="font-semibold text-lg mb-2">Chất lượng</h3>
            <p class="text-gray-600">Luôn đảm bảo trải nghiệm tốt nhất cho khách hàng.</p>
        </div>

        <div>
            <h3 class="font-semibold text-lg mb-2">Tận tâm</h3>
            <p class="text-gray-600">Hỗ trợ khách hàng nhanh chóng và nhiệt tình.</p>
        </div>

    </div>
</section>

{{-- ĐỘI NGŨ --}}
<section class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-slate-800 mb-10">
            Đội ngũ của chúng tôi
        </h2>

        <div class="grid md:grid-cols-3 gap-10">

            <div class="bg-white p-6 rounded-xl shadow">
                <img src="https://via.placeholder.com/150" 
                     class="mx-auto rounded-full mb-4" alt="">
                <h3 class="font-semibold">Nguyễn Văn A</h3>
                <p class="text-gray-500">CEO</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <img src="https://via.placeholder.com/150" 
                     class="mx-auto rounded-full mb-4" alt="">
                <h3 class="font-semibold">Trần Thị B</h3>
                <p class="text-gray-500">Marketing</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <img src="https://via.placeholder.com/150" 
                     class="mx-auto rounded-full mb-4" alt="">
                <h3 class="font-semibold">Lê Văn C</h3>
                <p class="text-gray-500">Tour Manager</p>
            </div>

        </div>
    </div>
</section>

@endsection