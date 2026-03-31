@extends('layouts.client')

@section('title', 'Liên hệ - TravelGo')

@section('banner')
    @include('clients.blocks.banner')
@endsection

@section('content')

{{-- GIỚI THIỆU --}}
<section class="max-w-7xl mx-auto px-4 py-16 text-center">
    <h2 class="text-3xl font-bold text-slate-800 uppercase mb-4">
        Liên hệ với chúng tôi
    </h2>
    <p class="text-gray-600 max-w-2xl mx-auto">
        Nếu bạn có bất kỳ câu hỏi nào về dịch vụ du lịch, hãy liên hệ với TravelGo. 
        Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7.
    </p>
</section>

{{-- THÔNG TIN + FORM --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    
    <div class="grid md:grid-cols-2 gap-12">

        {{-- THÔNG TIN LIÊN HỆ --}}
        <div>
            <h3 class="text-2xl font-semibold mb-6">Thông tin liên hệ</h3>

            <div class="space-y-4 text-gray-600">

                <p>📍 Địa chỉ: 123 Nguyễn Văn A, Hà Nội</p>

                <p>📞 Số điện thoại: 0123 456 789</p>

                <p>📧 Email: travelgo@gmail.com</p>

                <p>🕒 Giờ làm việc: 8:00 - 22:00 (T2 - CN)</p>

            </div>
        </div>

        {{-- FORM LIÊN HỆ --}}
        <div class="bg-white shadow-md rounded-xl p-8">

            <h3 class="text-2xl font-semibold mb-6 text-center">
                Gửi tin nhắn
            </h3>

            <form action="#" method="POST" class="space-y-5">

                {{-- Tên --}}
                <input type="text" name="name"
                    placeholder="Họ và tên"
                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                {{-- Email --}}
                <input type="email" name="email"
                    placeholder="Email"
                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                {{-- SĐT --}}
                <input type="text" name="phone"
                    placeholder="Số điện thoại"
                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                {{-- Nội dung --}}
                <textarea name="message" rows="5"
                    placeholder="Nội dung"
                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

                {{-- Button --}}
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Gửi liên hệ
                </button>

            </form>

        </div>

    </div>

</section>

{{-- MAP --}}
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">
            Bản đồ
        </h2>

        <div class="w-full h-[400px] rounded-xl overflow-hidden shadow">
            <iframe 
                src="https://www.google.com/maps?q=Hà+Nội&output=embed"
                class="w-full h-full border-0"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>
</section>

@endsection