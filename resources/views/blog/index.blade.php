@extends('blog.layout')
@section('main')
    <header class="py-10 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                دنیای <span class="text-indigo-600">تکنولوژی و هنر</span> را اینجا ورق بزنید
            </h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 pb-20">

        <section class="mb-16">
                <a href="{{ url('blog',$header->id) }}">
                    <div class="relative h-[450px] rounded-3xl overflow-hidden group cursor-pointer shadow-2xl">
                        <img src="{{ $header->image }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105" alt="Featured">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-8 text-white">
                            <span class="bg-indigo-500 w-fit px-3 py-1 rounded-lg text-sm mb-4">ویژه امروز</span>
                            <h2 class="text-3xl font-bold mb-2 leading-snug">{{ $header->title }}</h2>
                            <p class="text-slate-300 max-w-xl">{{ $header->summary }}</p>
                        </div>
                    </div>
                </a>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($blogs as $blog)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow border border-slate-100">
                    <img src="{{ asset($blog->image) }}" class="w-full h-48 object-cover" alt="Post">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-3 text-xs text-slate-400">
                            <span>۱۴ دی ۱۴۰۲</span>
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded">تکنولوژی</span>
                        </div>
                        <a href="{{ url('blog',$blog->id) }}">
                            <h3 class="text-xl font-bold mb-3 ">{{ $blog->title }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-4">{{ $blog->summary }}</p>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        @if($blogs->hasPages())
            <div class="flex flex-col items-center gap-4 py-8">
                <div class="flex items-center gap-1">
                    {{-- قبلی --}}
                    @if($blogs->onFirstPage())
                        <span class="p-2 rounded-lg text-slate-400 bg-slate-100 cursor-not-allowed">
                    ←
                </span>
                    @else
                        <a href="{{ $blogs->previousPageUrl() }}" class="p-2 rounded-lg text-slate-600 bg-white border border-slate-200 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            ←
                        </a>
                    @endif

                    {{-- صفحات --}}
                    @foreach($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                        @if($page == $blogs->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-600 text-white font-medium shadow-sm">
                        {{ $page }}
                    </span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-600 bg-white border border-slate-200 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-600 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- بعدی --}}
                    @if($blogs->hasMorePages())
                        <a href="{{ $blogs->nextPageUrl() }}" class="p-2 rounded-lg text-slate-600 bg-white border border-slate-200 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            →
                        </a>
                    @else
                        <span class="p-2 rounded-lg text-slate-400 bg-slate-100 cursor-not-allowed">
                    →
                </span>
                    @endif
                </div>

                <p class="text-sm text-slate-500">
                    صفحه {{ $blogs->currentPage() }} از {{ $blogs->lastPage() }}
                </p>
            </div>
        @endif

    </main>
@endsection
