@extends('layout.app')
@section('main')
<div class="w-full relative bg-black/90">
    @include('layout.menu')
</div>

<div class="w-full h-96 bg-no-repeat bg-cover bg-center bg-[url('{{$page->image}}')] relative">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-6xl font-extrabold uppercase text-white tracking-wider border-b-4 border-yellow-500 pb-2">
            {{$page->title}}
        </h1>
        <p class="mt-4 text-xl text-white font-light tracking-wide">
            {{$page->text}}
        </p>
    </div>
</div>
@foreach($banners as $banner)
<section class="py-24 bg-white">
    <div class="max-w-screen-xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="lg:pr-12">
            <h2 class="text-4xl font-extrabold uppercase tracking-widest text-gray-900 border-b-2 border-yellow-500 inline-block pb-1">
                {{$banner->title}}
            </h2>
            <p class="text-gray-700 mt-4 text-xl font-light leading-relaxed">
                {{$banner->text}}
            </p>
        </div>
        <div class="relative">
            <div class="h-96 w-full bg-cover bg-center bg-[url('{{$banner->image}}')] shadow-2xl rounded-xl"></div>
{{--            <div class="absolute -bottom-10 -right-4 bg-yellow-500 p-6 text-white text-2xl font-bold uppercase tracking-widest shadow-xl hidden md:block">--}}
{{--                Since 2010--}}
{{--            </div>--}}
        </div>
    </div>
</section>
@endforeach

<section class="py-24 bg-stone-50">
    <div class="max-w-screen-xl mx-auto px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold uppercase tracking-widest text-gray-900 border-b-2 border-yellow-500 inline-block pb-1">
                Our Core Values
            </h2>
            <p class="text-gray-600 mt-4 text-xl font-light">
                The principles that guide our every interaction and service.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            @foreach($services as $service)
                <div class="p-8 bg-white shadow-lg rounded-xl transition duration-300 hover:shadow-2xl">
                    <div class="text-5xl text-yellow-600 mb-4">
                        <ion-icon name="sparkles-outline"></ion-icon>
                    </div>
                    <h3 class="text-2xl font-bold uppercase tracking-wider text-gray-900 mb-3">
                        {{$service->title}}
                    </h3>
                    <p class="text-gray-700 font-light">
                        {{$service->summary}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
