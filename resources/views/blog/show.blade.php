@extends('layout.app')
@section('main')
    <div class="bg-black/80">
        @include('layout.menu')
    </div>
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
