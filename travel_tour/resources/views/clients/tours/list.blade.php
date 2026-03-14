@extends('layouts.client')

@section('title', $title)

@section('content')

<section class="max-w-7xl mx-auto px-4 py-16">

<h1 class="text-3xl font-bold mb-10">
{{ $title }}
</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

@foreach($tours as $tour)

@include('clients.blocks.tour-card')

@endforeach

</div>

<div class="mt-10">
{{ $tours->links() }}
</div>

</section>

@endsection