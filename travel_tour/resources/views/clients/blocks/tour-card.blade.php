<div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-50">

<div class="relative overflow-hidden aspect-[4/3] bg-slate-200">

@php

if($tour->thumbnail){
$displayImage = asset('storage/'.$tour->thumbnail);
}
elseif($tour->images->count()){
$displayImage = asset('storage/'.$tour->images->first()->image);
}
else{
$displayImage = 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?q=80&w=800';
}

@endphp

<img src="{{ $displayImage }}"
class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
alt="{{ $tour->name }}">

<div class="absolute top-5 left-5 bg-white/90 backdrop-blur-sm text-blue-600 px-4 py-1 rounded-full text-xs font-black shadow-sm">

{{ $tour->duration ?? '2 ngày 1 đêm' }}

</div>

</div>

<div class="p-8">

<div class="flex items-center gap-2 text-orange-500 text-xs font-bold uppercase mb-3">
<i class="fas fa-map-marker-alt"></i>
{{ $tour->category->name ?? 'Du lịch Việt Nam' }}
</div>

<h3 class="text-xl font-extrabold text-slate-800 mb-4 group-hover:text-blue-600 transition line-clamp-2">

<a href="{{ route('client.tours.show',$tour->slug) }}">
{{ $tour->name }}
</a>

</h3>

<div class="flex justify-between items-center pt-6 border-t border-slate-50">

<div>

<span class="text-slate-400 text-xs block mb-1">
Giá từ
</span>

<p class="text-2xl font-black text-blue-600">
{{ number_format($tour->price,0,',','.') }}đ
</p>

</div>

<a href="{{ route('client.tours.show',$tour->slug) }}"
class="bg-slate-900 text-white w-12 h-12 rounded-2xl flex items-center justify-center hover:bg-blue-600 transition">

<i class="fas fa-arrow-right"></i>

</a>

</div>

</div>

</div>