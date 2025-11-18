@extends('layout.app')
@section('main')
<div class="bg-black/80">
    @include('layout.menu')
</div>

<section class="py-24 bg-stone-50">
    <div class="max-w-screen-xl mx-auto px-8">
        <div class="text-center mb-16">
            <h1 class="text-6xl font-extrabold text-gray-900 tracking-wider">
                {{$page->title}}<span class="text-yellow-500">.</span>
            </h1>
            <p class="text-xl text-gray-600 mt-4 max-w-2xl mx-auto">
                {{$page->text}}
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($blogs as $blog)
                <article class="bg-white rounded-xl shadow-xl overflow-hidden group transform transition duration-500 hover:shadow-2xl
                hover:-translate-y-1 border-t-4 border-yellow-500">
                    <div class="h-56 w-full overflow-hidden">
                        <a href="{{route('blog.single',$blog->id)}}">
                            <img src="{{$blog->image}}" alt="Article Thumbnail" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        </a>
                    </div>
                    <div class="p-6">
{{--                        <span class="text-xs font-semibold uppercase tracking-widest text-yellow-600">Category Name</span>--}}
                        <h2 class="text-2xl font-bold text-gray-900 mt-2 mb-3 leading-snug">
                            <a href="{{route('blog.single',$blog->id)}}" class="hover:text-yellow-600 transition duration-200">
                                {{$blog->title}}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-base mb-4 line-clamp-3">
                            {{$blog->summary}}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <span class="text-sm text-gray-500 font-medium">
                                        {{$blog->created_at->diffForHumans()}}
                                    </span>
                            <a href="{{route('blog.single',$blog->id)}}" class="text-yellow-600 font-semibold text-sm uppercase tracking-wider hover:text-yellow-700 flex
                            items-center gap-1 transition duration-200">
                                Read More
                                <ion-icon name="arrow-forward-outline"></ion-icon>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-20 flex justify-center">
            <nav class="flex space-x-1" aria-label="Pagination">
                {{$blog->link}}
            </nav>
        </div>
    </div>
</section>
@endsection
