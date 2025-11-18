@extends('layout.app')
@section('main')
<header x-data="{ open: false }" class="relative z-20 flex flex-wrap items-center py-4 px-4 lg:px-16 border-b border-gray-100 bg-white shadow-md">
    <div class="flex-1 flex items-center justify-between">
        <a href="#" class="text-3xl font-extrabold text-gray-900 tracking-widest uppercase">
            LUXE<span class="text-yellow-500">.</span>
        </a>

        <button @click="open = !open" class="md:hidden text-gray-900 focus:outline-none">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="hidden md:flex space-x-8 text-gray-700 font-medium tracking-widest">
        <a href="#" class="hover:text-yellow-500 transition duration-200">Home</a>
        <a href="#" class="hover:text-yellow-500 transition duration-200">Services</a>
        <a href="#" class="hover:text-yellow-500 transition duration-200">About Us</a>
        <a href="#" class="hover:text-yellow-500 transition duration-200">Contact</a>
    </nav>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        @click.away="open = false"
        class="absolute top-full left-0 w-full bg-white/95 md:hidden z-40 shadow-lg"
    >
        <ul class="flex flex-col text-gray-700 font-medium tracking-widest">
            <li><a class="py-4 px-6 block border-b border-gray-100 hover:bg-gray-50" href="#">Home</a></li>
            <li><a class="py-4 px-6 block border-b border-gray-100 hover:bg-gray-50" href="#">Services</a></li>
            <li><a class="py-4 px-6 block border-b border-gray-100 hover:bg-gray-50" href="#">About Us</a></li>
            <li><a class="py-4 px-6 block hover:bg-gray-50" href="#">Contact</a></li>
        </ul>
    </div>
</header>

<section class="py-24 bg-stone-50">
    <div class="max-w-screen-xl mx-auto px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <header class="mb-10">
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-snug">
                        {{$blog->title}}
                    </h1>
{{--                    <div class="flex items-center text-gray-500 mt-4 text-sm font-medium space-x-4 space-x-reverse">--}}
{{--                        <span class="uppercase tracking-widest text-yellow-600">Wellness</span>--}}
{{--                        <span>|</span>--}}
{{--                        <time datetime="2024-11-18">November 18, 2024</time>--}}
{{--                        <span>|</span>--}}
{{--                        <span>By: Eleanor Vance</span>--}}
{{--                    </div>--}}
                </header>

                <figure class="mb-12">
                    <img src="{{asset($blog->image)}}" alt="Featured image for the blog post"
                         class="w-full h-auto object-cover rounded-xl shadow-xl border-4 border-white">
                </figure>

                <div class="prose max-w-none text-gray-700 leading-relaxed space-y-6">
                    {!! $blog->description !!}
                </div>

{{--                <div class="mt-12 pt-6 border-t border-gray-200 flex items-center flex-wrap gap-3">--}}
{{--                    <span class="text-sm font-bold uppercase text-gray-800">Tags:</span>--}}
{{--                    <a href="#" class="px-4 py-1 text-sm rounded-full bg-gray-200 text-gray-700 hover:bg-yellow-100 hover:text-yellow-800 transition duration-200">#EliteFitness</a>--}}
{{--                    <a href="#" class="px-4 py-1 text-sm rounded-full bg-gray-200 text-gray-700 hover:bg-yellow-100 hover:text-yellow-800 transition duration-200">#Wellness</a>--}}
{{--                    <a href="#" class="px-4 py-1 text-sm rounded-full bg-gray-200 text-gray-700 hover:bg-yellow-100 hover:text-yellow-800 transition duration-200">#Recovery</a>--}}
{{--                </div>--}}

{{--                <div class="mt-10 p-6 bg-white rounded-xl shadow-lg flex items-center justify-between">--}}
{{--                    <span class="text-lg font-bold text-gray-700">Share This Insight:</span>--}}
{{--                    <div class="flex space-x-4">--}}
{{--                        <a href="javascript:;" class="text-2xl text-gray-500 hover:text-yellow-600 transition duration-200">--}}
{{--                            <ion-icon name="logo-twitter"></ion-icon>--}}
{{--                        </a>--}}
{{--                        <a href="javascript:;" class="text-2xl text-gray-500 hover:text-yellow-600 transition duration-200">--}}
{{--                            <ion-icon name="logo-linkedin"></ion-icon>--}}
{{--                        </a>--}}
{{--                        <a href="javascript:;" class="text-2xl text-gray-500 hover:text-yellow-600 transition duration-200">--}}
{{--                            <ion-icon name="logo-facebook"></ion-icon>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>
            <aside class="lg:col-span-1">

{{--                <div class="p-6 bg-white rounded-xl shadow-lg mb-10 text-center">--}}
{{--                    <h3 class="text-xl font-bold mb-4 uppercase tracking-wider text-gray-800">About The Author</h3>--}}
{{--                    <img src="./14.jpg" alt="Author Photo" class="w-24 h-24 rounded-full mx-auto object-cover mb-4 border-4 border-yellow-600/50">--}}
{{--                    <h4 class="text-lg font-bold text-gray-900">Eleanor Vance</h4>--}}
{{--                    <p class="text-sm text-gray-600 mt-1 italic">LUXE Wellness Director</p>--}}
{{--                    <p class="text-sm text-gray-700 mt-4 leading-relaxed">--}}
{{--                        Eleanor is a certified performance coach with a focus on bio-hacking and restorative luxury. She curates the recovery protocols for our most elite clientele.--}}
{{--                    </p>--}}
{{--                </div>--}}

                <div class="p-6 bg-white rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold mb-6 uppercase tracking-wider text-gray-800 border-b pb-2 border-yellow-500">Related Articles</h3>
                    <ul class="space-y-6">
                        @foreach(\App\Models\Blog::latest()->take(3)->get() as $blog)
                        <li class="flex items-start gap-4 hover:bg-stone-50 p-2 -m-2 rounded-lg transition duration-200">
                            <img src="{{ asset($blog->image) }}" alt="Related Post" class="w-16 h-16 object-cover rounded-md flex-shrink-0 border border-gray-100">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 leading-snug hover:text-yellow-600">{{$blog->title}}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $blog->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
