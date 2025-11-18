@extends('layout.app')
@section('main')
    <div class="w-full relative bg-black/90">
        @include('layout.menu')
    </div>

    <div class="w-full h-96 bg-no-repeat bg-cover bg-center bg-[url('{{$page->image}}')] relative">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-6xl font-extrabold uppercase text-white tracking-wider border-b-4 border-yellow-500 pb-2">
                {{$page->title}}
            </h1>
            <p class="mt-4 text-xl text-white font-light tracking-wide">
                {{$page->text}}
            </p>
        </div>
    </div>

    <section class="py-24 bg-white">
        <div class="max-w-screen-xl mx-auto px-8">
            <div class="text-center mb-20 relative z-10">
                <h2 class="text-4xl font-extrabold uppercase tracking-widest text-gray-900 border-b-2 border-yellow-500 inline-block pb-1">
                    The LUXE Experience
                </h2>
                <p class="text-gray-600 mt-4 text-xl font-light">
                    Discover the tailored pillars of our high-end health and fitness offering.
                </p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                @foreach($services as $service)
                <div class="flex flex-col md:flex-row bg-stone-50 shadow-2xl rounded-xl overflow-hidden group">
                    <div class="md:w-1/2 min-h-[16rem] bg-cover bg-center bg-[url('{{$service->image}}')]">
                    </div>
                    <div class="md:w-1/2 p-8 flex flex-col justify-center">
                        <h3 class="text-3xl font-bold uppercase tracking-widest text-gray-900 mb-4 group-hover:text-yellow-600 transition duration-300">
                            {{$service->title}}
                        </h3>
                        <p class="text-gray-700 mb-6 font-light">
                            {{$service->description}}
                        </p>
{{--                        <a href="#" class="mt-6 inline-block text-black font-bold hover:text-yellow-600 transition duration-200 uppercase tracking-wider">--}}
{{--                            Request Consultation →--}}
{{--                        </a>--}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @foreach($banners->take(1) as $banner)
        <div class="relative overflow-hidden bg-neutral-100">
            <div class="pt-16 pb-32 sm:pt-24 sm:pb-40 lg:pt-40 lg:pb-48">
                <div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
                    <div class="lg:flex lg:items-center lg:gap-x-8">
                        <div class="lg:w-3/5 sm:max-w-xl">
                            <h2 class="font text-5xl font-bold tracking-tight text-gray-900 sm:text-7xl leading-tight">
                                {{$banner->title}}
                            </h2>
                            <p class="mt-6 text-xl text-gray-600 font-light">
                                {{$banner->text}}
                            </p>
                            @if($banner->link)
                                <a href="{{$banner->link}}" class="mt-10 inline-block rounded-md border border-transparent bg-yellow-600 py-3 px-8
                            text-center font-bold tracking-widest text-white hover:bg-yellow-700 shadow-lg transition duration-300">
                                    {{$banner->label}}
                                </a>
                            @endif
                        </div>
                        <div class="hidden lg:block lg:w-3/5 lg:mt-0 mt-10">
                            <div class="relative w-full h-auto max-w-full mx-auto overflow-hidden rounded-lg shadow-2xl">
                                <img src="{{$banner->image}}" alt="تصویر اصلی بنر" class="w-full h-full object-cover object-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
