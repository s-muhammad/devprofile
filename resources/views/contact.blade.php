@extends('layout.app')
@section('main')
    <div class="w-full relative bg-black/90">
        @include('layout.menu')
    </div>

    <div class="w-full h-96 bg-no-repeat bg-cover bg-center bg-[url('{{$page->image}}')] relative">
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-6xl font-extrabold uppercase text-white tracking-wider border-b-4 border-yellow-500 pb-2">
                {{$page->title}}
            </h1>
            <p class="mt-4 text-xl text-white font-light tracking-wide">
                {{$page->text}}
            </p>
        </div>
    </div>

    <section class="py-24 bg-stone-50">
        <div class="max-w-screen-xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-3 gap-12">

            <div class="lg:col-span-1 space-y-8 p-8 bg-white shadow-xl rounded-xl h-full">
                <h2 class="text-3xl font-extrabold uppercase tracking-widest text-gray-900 border-b-2 border-yellow-500 inline-block pb-1 mb-6">
                    Direct Contact
                </h2>

                <div class="flex items-start space-x-4">
                    <div class="text-yellow-600 text-3xl pt-1">
                        <ion-icon name="call-outline"></ion-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg uppercase tracking-wider text-gray-900">Phone</h3>
                        <p class="text-gray-700 font-light">{{setting('site_phone')}}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-yellow-600 text-3xl pt-1">
                        <ion-icon name="mail-outline"></ion-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg uppercase tracking-wider text-gray-900">Email</h3>
                        <p class="text-gray-700 font-light">{{setting('site_email')}}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-yellow-600 text-3xl pt-1">
                        <ion-icon name="location-outline"></ion-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg uppercase tracking-wider text-gray-900">Address</h3>
                        <p class="text-gray-700 font-light">
                            {{setting('site_address')}}
                        </p>
                    </div>
                </div>

                <div class="pt-4">
                    <h3 class="font-bold text-lg uppercase tracking-wider text-gray-900 mb-2">Hours</h3>
                    <p class="text-gray-700 font-light">
                        {{setting('site_hours')}}
                    </p>
                </div>
            </div>

            <div class="lg:col-span-2 p-10 bg-white shadow-xl rounded-xl">
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-extrabold uppercase tracking-widest text-gray-900 border-b-2 border-yellow-500 inline-block pb-1">
                        Our Location
                    </h2>
                    <p class="text-gray-600 mt-4 text-xl font-light">
                        Visit our exclusive facility for a personalized tour.
                    </p>
                </div>
                <div class="h-96 w-full shadow-2xl rounded-xl overflow-hidden">
                    <iframe src="{{setting('site_location')}}"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
