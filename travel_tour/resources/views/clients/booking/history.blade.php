@extends('layouts.client')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<div class="max-w-6xl mx-auto py-16 px-4">

    <h2 class="text-3xl font-black text-slate-800 mb-8 uppercase">
        Lịch sử đặt tour của bạn
    </h2>

    <div class="space-y-6">

        @forelse($bookings as $booking)

        @php

        // =====================
        // TOUR
        // =====================
        $tour = $booking->trip->tour ?? null;

        // =====================
        // ẢNH
        // =====================
        $displayUrl = null;

        if($tour && $tour->thumbnail){
            if(Str::startsWith($tour->thumbnail,['http://','https://'])){
                $displayUrl = $tour->thumbnail;
            }
            elseif(file_exists(public_path('storage/'.$tour->thumbnail))){
                $displayUrl = asset('storage/'.$tour->thumbnail);
            }
            elseif(file_exists(public_path($tour->thumbnail))){
                $displayUrl = asset($tour->thumbnail);
            }
        }

        if(!$displayUrl){
            $displayUrl = 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?q=80&w=800';
        }

        // =====================
        // TIỀN
        // =====================
        $totalPaid = $booking->payments->where('status','paid')->sum('amount');
        $remaining = $booking->total_price - $totalPaid;

        // =====================
        // TRẠNG THÁI (CHUẨN)
        // =====================
        switch($booking->status){

            case 'pending':
                $statusText = 'Chờ thanh toán';
                $statusClass = 'bg-yellow-100 text-yellow-700';
                break;

            case 'deposit_paid':
                $statusText = 'Đã đặt cọc';
                $statusClass = 'bg-blue-100 text-blue-700';
                break;

            case 'paid':
                $statusText = 'Đã thanh toán đủ';
                $statusClass = 'bg-green-100 text-green-700';
                break;

            case 'completed':
                $statusText = 'Hoàn thành';
                $statusClass = 'bg-green-200 text-green-800';
                break;

            case 'canceled':
                $statusText = 'Đã hủy';
                $statusClass = 'bg-red-100 text-red-700';
                break;

            default:

                // fallback theo tiền nếu DB sai
                if($totalPaid <= 0){
                    $statusText = 'Chờ thanh toán';
                    $statusClass = 'bg-yellow-100 text-yellow-700';
                }
                elseif($totalPaid < $booking->deposit_amount){
                    $statusText = 'Chưa đủ tiền cọc';
                    $statusClass = 'bg-orange-100 text-orange-700';
                }
                elseif($totalPaid < $booking->total_price){
                    $statusText = 'Đã đặt cọc';
                    $statusClass = 'bg-blue-100 text-blue-700';
                }
                else{
                    $statusText = 'Đã thanh toán đủ';
                    $statusClass = 'bg-green-100 text-green-700';
                }
        }

        @endphp


        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col md:flex-row gap-6 hover:shadow-md transition">

            {{-- ẢNH --}}
            <div class="md:w-1/4">
                <img src="{{ $displayUrl }}"
                     onerror="this.src='https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=800'"
                     class="w-full h-32 md:h-40 object-cover rounded-2xl shadow-sm">
            </div>

            {{-- THÔNG TIN --}}
            <div class="flex-1">

                <div class="flex justify-between items-start mb-2">

                    <h3 class="text-xl font-bold text-slate-800">
                        {{ $tour->name ?? 'Tour đã xóa' }}
                    </h3>

                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                </div>

                <div class="text-slate-500 text-sm space-y-2">

                    <p>
                        Ngày đặt:
                        {{ optional($booking->created_at)->format('d/m/Y') }}
                    </p>

                    <p>
                        Số lượng:
                        {{ $booking->quantity }} khách
                    </p>

                </div>

                {{-- TIỀN --}}
                <div class="pt-3 border-t border-slate-100 mt-3 space-y-1">

                    <p>
                        Tổng tiền:
                        <span class="font-bold text-red-600">
                            {{ number_format($booking->total_price) }}đ
                        </span>
                    </p>

                    <p>
                        Đã thanh toán:
                        <span class="font-bold text-green-600">
                            {{ number_format($totalPaid) }}đ
                        </span>
                    </p>

                    <p>
                        Còn lại:
                        <span class="font-bold text-orange-600">
                            {{ number_format($remaining) }}đ
                        </span>
                    </p>

                </div>

                {{-- NÚT --}}
                <div class="mt-4 flex gap-2 flex-wrap">

                    <a href="{{ route('booking.show',$booking->id) }}"
                       class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                        Xem chi tiết
                    </a>

                    {{-- NÚT THANH TOÁN TIẾP --}}
                    @if($booking->status !== 'paid' && $booking->status !== 'completed' && $booking->status !== 'canceled')

                        @if($totalPaid < $booking->deposit_amount)
                            <a href="{{ route('payment.vnpay',$booking->id) }}"
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600">
                                Thanh toán cọc
                            </a>
                        @elseif($totalPaid < $booking->total_price)
                            <a href="{{ route('payment.vnpayFinal',$booking->id) }}"
                               class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                                Thanh toán còn lại
                            </a>
                        @endif

                    @endif

                </div>

            </div>

        </div>

        @empty

        <div class="text-center py-20 bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">

            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076402.png"
                 class="w-20 h-20 mx-auto mb-4 opacity-20">

            <p class="text-slate-400 italic text-lg">
                Bạn chưa thực hiện đơn đặt tour nào.
            </p>

            <a href="{{ url('/') }}"
               class="inline-block mt-4 text-blue-600 font-bold hover:underline">
                Khám phá tour ngay
            </a>

        </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-10">
        {{ $bookings->links() }}
    </div>

</div>

@endsection