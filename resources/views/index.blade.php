@extends('layout.app')
@section('main')
    <div class="w-full h-screen bg-no-repeat bg-cover bg-center bg-[url({{$page['image']}})] relative">
        <div class="absolute inset-0 bg-black/20"></div>
        @include('layout.menu')
        <div class="relative z-10 w-[90%] mx-auto h-full flex items-center justify-between py-10">
            <div class="lg:w-fit mt-10">
                <div class="text-4xl sm:text-6xl text-left text-white font-serif font-extrabold uppercase leading-tight">
                    <div class="header-container">
                        @php
                            $words = explode(' ', $page->text);
                        @endphp
                        @foreach ($words as $index => $word)
                            @if ($index == 2)
                                {!! '<h1 class="text-yellow-500">' . $word . '</h1>' !!}
                            @else
                                {!! '<h1>' . $word . '</h1>' !!}
                            @endif
                        @endforeach
                    </div>
                </div>

                {{--            <div class="mt-8">--}}
                {{--                <a href="#" class="inline-block py-4 px-8 uppercase bg-black text-white text-lg font-bold tracking-widest border-2 --}}
                {{--                border-yellow-500 rounded-sm shadow-xl transition duration-300 ease-in-out hover:bg-yellow-500 hover:text-black">--}}
                {{--                    Join Our Elite Circle--}}
                {{--                </a>--}}
                {{--            </div>--}}

                {{--            <p class="text-md text-white bg-black/50 font-semibold mt-4 capitalize rounded-lg py-2 px-4 inline-block tracking-wider">--}}
                {{--                Exclusive 25% Introductory Discount--}}
                {{--            </p>--}}
            </div>
            <div class="hidden md:flex flex-col gap-4 items-center text-xl text-white">
                @if(setting('social_twitter'))
                    <a href="{{setting('social_twitter')}}"
                       class="w-10 h-10 rounded-full bg-black/40 hover:bg-yellow-500 hover:text-black transition duration-300 flex justify-center items-center">
                        <ion-icon name="logo-twitter"></ion-icon>
                    </a>
                @endif
                @if(setting('social_instagram'))
                    <a href="{{setting('social_instagram')}}"
                       class="w-10 h-10 rounded-full bg-black/40 hover:bg-yellow-500 hover:text-black transition duration-300 flex justify-center items-center">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a>
                @endif
                @if(setting('social_facebook'))
                    <a href="{{setting('social_facebook')}}"
                       class="w-10 h-10 rounded-full bg-black/40 hover:bg-yellow-500 hover:text-black transition duration-300 flex justify-center items-center">
                        <ion-icon name="logo-facebook"></ion-icon>
                    </a>
                @endif
                @if(setting('social_youtube'))
                    <a href="{{setting('social_youtube')}}"
                       class="w-10 h-10 rounded-full bg-black/40 hover:bg-yellow-500 hover:text-black transition duration-300 flex justify-center items-center">
                        <ion-icon name="logo-youtube"></ion-icon>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <section class="py-24 bg-stone-50">
        <div class="max-w-screen-xl mx-auto px-8">
            <div class="text-center mb-20 relative z-10">
                <h2 class="text-4xl font-extrabold uppercase tracking-widest text-gray-900 border-b-2 border-yellow-500 inline-block pb-1">
                    Signature Services
                </h2>
                <p class="text-gray-600 mt-4 text-xl font-light">
                    An exclusive look into our world of high-end service.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-0">
                @foreach($services as $service)
                    <article
                        class="mx-auto shadow-2xl bg-cover bg-center min-h-[22rem] md:min-h-[30rem] relative border-4 border-black/10 transform
                duration-500 hover:-translate-y-6 group"
                        style="background-image: url('{{$service->image}}');background-repeat: no-repeat;"
                    >
                        <div class="absolute inset-0 bg-black/5 transition-all duration-500 group-hover:bg-black/30"></div>
                        <div class="relative p-10 h-full flex flex-col justify-end">
                            <h1 class="text-white text-3xl mb-4 transform translate-y-16 uppercase font-bold tracking-widest group-hover:translate-y-0
                    duration-500 group-hover:text-yellow-500">
                                {{$service->title}}
                            </h1>
                            <p class="opacity-0 text-white text-lg font-light group-hover:opacity-100 transform duration-500 delay-100">
                                {{$service->summary}}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @foreach($banners->take(1) as $banner)
        <div class="relative overflow-hidden bg-white">
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

    <section class="py-24 bg-stone-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-extrabold uppercase tracking-widest text-gray-900 border-b-2 border-yellow-500 inline-block pb-1">Exclusive Insights</h2>
                <p class="text-gray-600 mt-4 text-xl font-light">Curated articles on elite fitness and luxury lifestyle.</p>
            </div>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($blogs as $blog)
                        <div class="swiper-slide lg:w-full">
                            <div class="h-full bg-white shadow-xl rounded-xl overflow-hidden transition duration-300 hover:scale-[1.03]">
                                <img class="h-48 w-full object-cover object-center" src="{{$blog->image}}" alt="blog">
                                <div class="p-6">
                                    {{--                            <h2 class="tracking-widest text-xs title-font font-medium text-yellow-600 mb-1 uppercase">Wellness</h2>--}}
                                    <h1 class="title-font text-xl font-bold text-gray-900 mb-3">{{$blog->title}}</h1>
                                    <p class="leading-relaxed mb-4 text-gray-700">{{$blog->summary}}</p>
                                    <div class="flex items-center flex-wrap">
                                        <a href="{{route('blog.single',$blog->id)}}"
                                           class="text-black inline-flex items-center md:mb-2 lg:mb-0 font-bold hover:text-yellow-600
                                    transition duration-200"
                                        >Learn More...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-12 text-center"></div>
            </div>
        </div>
    </section>
@endsection
