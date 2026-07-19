@extends('blog.layout')
@section('main')
    <main class="max-w-7xl mx-auto px-4 py-10">

        <nav class="flex text-slate-400 text-xs mb-6 gap-2">
            <a href="{{ url('/blog') }}" class="hover:text-indigo-600">خانه</a>
            <span>/</span>
            <a href="{{ url('blog',$blog->id) }}" class="hover:text-indigo-600">{{ $blog->title }}</a>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <article class="lg:col-span-8 bg-white rounded-3xl p-6 md:p-10 shadow-sm border border-slate-100">

                <header class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full">تکنولوژی</span>
                        <span class="text-slate-400 text-xs">زمان مطالعه: ۱ دقیقه</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mb-8 text-slate-800">{{ $blog->title }}</h1>

                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                        <img src="{{ asset('/uploads/1757138423.png') }}" class="w-12 h-12 rounded-full border-2 border-white shadow-sm" alt="Author">
                        <div>
                            <p class="font-bold text-slate-800">سیدمحمد محمدی</p>
                            <p class="text-xs text-slate-500">نویسنده ارشد و توسعه‌دهنده وب</p>
                        </div>
                        <div class="mr-auto text-xs text-slate-400">{{ $blog->created_at->format('Y M d') }}</div>
                    </div>
                </header>
                <img src="{{ asset($blog->image) }}" class="w-full h-[400px] object-cover rounded-2xl mb-10 shadow-lg" alt="Cover">
                <div class="prose prose-slate max-w-none text-slate-700 leading-8 space-y-6">
                    <p>{!! $blog->description !!}</p>
                </div>

                <div class="mt-16 pt-8 border-t border-slate-100 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex gap-2">
                        <span class="bg-slate-100 px-3 py-1 rounded-lg text-xs text-slate-600">#برنامه_نویسی</span>
                        <span class="bg-slate-100 px-3 py-1 rounded-lg text-xs text-slate-600">#توسعه_وب</span>
                    </div>
                    <div class="flex gap-3">
                        <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition">𝕏</button>
                        <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition">in</button>
                    </div>
                </div>

                <section class="mt-20">
                    <h3 class="text-2xl font-bold mb-8 flex items-center gap-3">
                        <span>نظرات کاربران</span>
                        <span class="bg-slate-200 text-slate-700 text-sm px-2 py-0.5 rounded-md">{{ $comments->count() }}</span>
                    </h3>
                    @foreach($comments as $comment)
                        <div class="space-y-6 mb-10">
                            <div class="flex gap-4 p-4 border border-slate-100 rounded-2xl">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 shrink-0"></div>
                                <div>
                                    <h4 class="font-bold text-sm">{{ $comment->name }}</h4>
                                    <p class="text-xs text-slate-400 mb-2">{{ $comment->created_at->diffForHumans() }}</p>
                                    <p class="text-sm text-slate-600">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <h4 class="font-bold mb-4">ارسال نظر</h4>
                        <form action="{{ route('comment.store') }}" method="post">
                            @csrf
                            @method('post')
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">

                            <!-- فیلد نام -->
                            <input type="text" name="name"
                                   class="w-full bg-white border border-slate-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-indigo-500 outline-none mb-4"
                                   placeholder="نام شما..."
                                   value="{{ old('name') }}"
                                   required>

                            <!-- فیلد کامنت -->
                            <textarea rows="4" name="comment"
                                      class="w-full bg-white border border-slate-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-indigo-500 outline-none mb-4"
                                      placeholder="نظر شما..."
                                      required>{{ old('comment') }}</textarea>

                            <!-- بخش کپچا -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">
                                    سوال امنیتی:
                                </label>

                                <div class="text-lg font-bold bg-gray-100 p-3 rounded-lg text-center mb-2">
                                    {{ session('comment_captcha_question') }}
                                </div>

                                <input type="number"
                                       name="captcha_answer"
                                       class="w-full bg-white border border-slate-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                       placeholder="پاسخ را وارد کنید"
                                       value="{{ old('captcha_answer') }}"
                                       required>

                                @error('captcha_answer')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- دکمه ارسال -->
                            <button type="submit"
                                    class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                                ارسال دیدگاه
                            </button>
                        </form>
                    </div>
                </section>
            </article>

            <aside class="lg:col-span-4 space-y-10">

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-lg mb-4 pb-2 border-b-2 border-indigo-500 w-fit">درباره نویسنده</h4>
                    <p class="text-sm text-slate-500 leading-7">
                         بیش از 5 سال تجربه در توسعه پروژه‌های متن‌باز دارد و عاشق نوشتن درباره تکنولوژی‌های جدید است.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-lg mb-6">مقالات پیشنهادی</h4>
                    <div class="space-y-6">
                        @foreach(\App\Models\Blog::latest()->take(3)->get() as $blog)
                            <a href="{{ url('blog',$blog->id) }}" class="group flex gap-4 items-center">
                                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                                    <img src="{{ asset($blog->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition" alt="Small Thumb">
                                </div>
                                <h5 class="text-sm font-bold group-hover:text-indigo-600 transition">{{ $blog->title }}</h5>
                            </a>
                        @endforeach
                    </div>
                </div>

{{--                <div class="bg-indigo-600 rounded-3xl p-8 text-white">--}}
{{--                    <h4 class="text-xl font-bold mb-3">عضویت در خبرنامه</h4>--}}
{{--                    <p class="text-indigo-100 text-xs leading-6 mb-6">بهترین مقالات هفته را در ایمیل خود دریافت کنید.</p>--}}
{{--                    <input type="email" placeholder="ایمیل شما" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-sm outline-none mb-4 placeholder:text-indigo-200">--}}
{{--                    <button class="w-full bg-white text-indigo-600 font-bold py-2 rounded-xl hover:bg-indigo-50 transition">ثبت نام</button>--}}
{{--                </div>--}}

            </aside>
        </div>
    </main>
@endsection
