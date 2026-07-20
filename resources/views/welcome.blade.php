@extends('partials.layout')
@section('main')
    <!-- HERO -->
    <section
        class="max-w-[1320px] mx-auto px-6 lg:px-14 pt-14 md:pt-20 pb-20 grid md:grid-cols-2 gap-14 items-center overflow-hidden">
        <div class="text-center md:text-right order-2 md:order-1">
            <span
                class="pill inline-block text-xs font-bold px-4 py-1.5 rounded-full mb-6">در دسترس برای پروژه‌های جدید</span>
            <h1 class="text-4xl md:text-[52px] font-extrabold leading-[1.35] mb-6">
                ایده‌ی شما را با <span class="text-[var(--accent)]">Laravel</span> به محصولی <span
                    class="text-[var(--accent)]">واقعی</span> تبدیل می‌کنم
            </h1>
            <p class="text-base md:text-lg text-[var(--muted)] leading-8 mb-9 max-w-lg mx-auto md:mx-0">
                توسعه‌دهنده‌ی متمرکز بر اکوسیستم لاراول؛ از پایه‌ی دیتابیس تا رابط کاربری زنده با Livewire، کدی تمیز و
                مقیاس‌پذیر تحویل می‌دهم.
            </p>
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                <a href="#projects" class="btn-primary text-white px-7 py-3.5 rounded-full font-bold text-sm">نمونه‌کارها
                    را ببینید</a>
                <a href="#articles"
                   class="border border-[var(--border)] px-7 py-3.5 rounded-full font-bold text-sm hover:bg-[var(--bg-soft)] transition-colors">مقالات
                    فنی</a>
            </div>
        </div>

        <div class="relative order-1 md:order-2 h-[340px] md:h-[420px] hidden md:block">
            <div class="blob absolute -top-6 -left-6 w-56 h-56 rounded-full bg-[var(--accent)]/25"></div>
            <div class="blob absolute bottom-0 right-6 w-44 h-44 rounded-full bg-[#FF7A59]/20"></div>

            <!-- website mockup -->
            <div class="mock-frame absolute inset-x-4 top-6 md:top-10 shadow-xl">
                <div class="mock-bar flex items-center gap-1.5 px-4 py-3">
                    <span class="mock-dot bg-[#FF6159]"></span>
                    <span class="mock-dot bg-[#FFC02E]"></span>
                    <span class="mock-dot bg-[#28C93F]"></span>
                    <span class="mono text-[10px] text-[var(--muted)] mr-3" dir="ltr">devprofile.ir</span>
                </div>
                <div class="p-5">
                    <!-- mini nav -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-1.5">
                            <div class="w-5 h-5 rounded-md bg-[#171923] flex items-center justify-center shrink-0">
                                <span class="text-white text-[8px]">🛍</span>
                            </div>
                            <span class="text-[9px] font-extrabold whitespace-nowrap">فروشگاه ویترین</span>
                        </div>
                        <div
                            class="hidden sm:flex items-center gap-3 text-[8px] font-bold text-[var(--muted)] whitespace-nowrap">
                            <span class="text-[var(--ink)] relative">محصولات<span
                                    class="absolute -bottom-1.5 inset-x-0 h-[1.5px] bg-[var(--accent)]"></span></span>
                            <span>تخفیف‌ها</span>
                            <span>تماس</span>
                        </div>
                        <div
                            class="relative w-6 h-6 rounded-full bg-[var(--bg-soft)] flex items-center justify-center shrink-0">
                            <span class="text-[9px]">🛒</span>
                            <span
                                class="absolute -top-0.5 -left-0.5 w-2.5 h-2.5 rounded-full bg-[var(--accent)] text-white text-[6px] flex items-center justify-center">۲</span>
                        </div>
                    </div>

                    <!-- mini hero -->
                    <div class="grid grid-cols-5 gap-4 items-center">
                        <div class="col-span-3 flex flex-col gap-2">
                            <span
                                class="inline-flex w-fit text-[6.5px] font-bold px-2 py-1 rounded-full bg-[#FFF1EC] text-[#FF6B4A] whitespace-nowrap">۳۰٪ تخفیف ویژه امروز</span>
                            <p class="text-[12px] font-extrabold leading-snug mt-1 whitespace-nowrap">
                                کالای اصل با <span class="text-[var(--accent)]">ارسال رایگان</span>
                            </p>
                            <div class="bar h-2 w-full mt-0.5"></div>
                            <div class="bar h-2 w-4/5"></div>
                            <div class="flex items-center gap-2 mt-1.5">
                                <div class="h-6 px-3 rounded-full bg-[var(--ink)] flex items-center shrink-0">
                                    <span class="text-white text-[7px] font-bold whitespace-nowrap">خرید کنید</span>
                                </div>
                                <span
                                    class="text-[9px] font-extrabold text-[var(--accent)] whitespace-nowrap">۴۹۰,۰۰۰ت</span>
                            </div>
                        </div>
                        <div class="col-span-2 relative">
                            <div
                                class="thumb-1 rounded-xl h-32 relative overflow-hidden flex items-center justify-center">
                                <span class="text-white/90 text-lg">🎁</span>
                                <div class="absolute -bottom-4 -right-4 w-16 h-16 rounded-full bg-white/10"></div>
                                <div class="absolute top-3 left-3 w-8 h-8 rounded-full bg-white/15"></div>
                            </div>
                            <div
                                class="absolute -bottom-3 -left-3 bg-white rounded-lg shadow-md border border-[var(--border)] px-2.5 py-1.5 flex items-center gap-1 whitespace-nowrap">
                                <span class="text-[8px] text-[#FFB020]">★★★★★</span>
                                <span class="text-[6.5px] text-[var(--muted)] font-bold">(۲۴۰)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- floating badge: tech -->
            <div
                class="float-card absolute -bottom-2 -right-2 md:right-4 bg-white rounded-2xl shadow-lg border border-[var(--border)] px-4 py-3 flex items-center gap-3"
                style="--r:-2deg; animation-delay:.2s;">
                <div
                    class="w-8 h-8 rounded-full bg-[var(--accent-soft)] flex items-center justify-center text-[var(--accent)] text-xs font-bold">
                    LW
                </div>
                <div>
                    <p class="text-xs font-bold" dir="ltr">Livewire</p>
                    <p class="text-[10px] text-[var(--muted)]">UI Layer</p>
                </div>
            </div>

            <!-- floating badge: tech -->
            <div
                class="float-card absolute top-2 -left-2 md:-left-6 bg-white rounded-2xl shadow-lg border border-[var(--border)] px-4 py-3 flex items-center gap-3"
                style="--r:2deg; animation-delay:1s;">
                <div
                    class="w-8 h-8 rounded-full bg-[#E9FBF0] flex items-center justify-center text-[#1FA971] text-xs font-bold">
                    DB
                </div>
                <div>
                    <p class="text-xs font-bold" dir="ltr">MySQL</p>
                    <p class="text-[10px] text-[var(--muted)]">Database</p>
                </div>
            </div>

            <!-- floating chip -->
            <div
                class="float-card absolute bottom-16 left-0 md:-left-4 bg-[var(--ink)] text-white rounded-full shadow-lg px-4 py-2 mono text-[11px] font-bold"
                dir="ltr" style="--r:-3deg; animation-delay:1.6s;">
                PHP 8.x
            </div>
        </div>
    </section>

    <!-- SKILLS -->
    <section id="skills" class="max-w-[1320px] mx-auto px-6 lg:px-14 py-16">
        <div class="reveal text-center mb-14">
            <p class="text-[var(--accent)] font-bold text-sm mb-3">مهارت‌های تخصصی</p>
            <h2 class="text-3xl md:text-4xl font-extrabold">تکنولوژی‌هایی که هر روز باهاشون کار می‌کنم</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="reveal card p-6">
                <div
                    class="w-11 h-11 rounded-xl thumb-4 flex items-center justify-center text-white font-bold text-sm mb-5">
                    PHP
                </div>
                <h3 class="font-bold mb-2">PHP 8.x</h3>
                <p class="text-sm text-[var(--muted)] leading-6">توسعه‌ی کدهای سمت سرور مدرن، شیءگرا و با پرفورمنس
                    بالا.</p>
            </div>
            <div class="reveal card p-6">
                <div
                    class="w-11 h-11 rounded-xl thumb-1 flex items-center justify-center text-white font-bold text-sm mb-5">
                    LV
                </div>
                <h3 class="font-bold mb-2">Laravel</h3>
                <p class="text-sm text-[var(--muted)] leading-6">ساخت اپلیکیشن‌های پیچیده‌ی وب با فریم‌ورک محبوب
                    لاراول.</p>
            </div>
            <div class="reveal card p-6">
                <div
                    class="w-11 h-11 rounded-xl thumb-2 flex items-center justify-center text-white font-bold text-sm mb-5">
                    LW
                </div>
                <h3 class="font-bold mb-2">Livewire</h3>
                <p class="text-sm text-[var(--muted)] leading-6">ساخت رابط کاربری داینامیک و مدرن بدون خروج از دنیای
                    PHP.</p>
            </div>
            <div class="reveal card p-6">
                <div
                    class="w-11 h-11 rounded-xl thumb-3 flex items-center justify-center text-white font-bold text-sm mb-5">
                    DB
                </div>
                <h3 class="font-bold mb-2">MySQL</h3>
                <p class="text-sm text-[var(--muted)] leading-6">طراحی دیتابیس‌های بهینه و مدیریت روابط و کوئری‌های
                    سنگین.</p>
            </div>
        </div>
    </section>

    <!-- PROJECTS -->
    <section id="projects" class="max-w-[1320px] mx-auto px-6 lg:px-14 py-16">
        <div class="reveal flex items-end justify-between flex-wrap gap-4 mb-12">
            <div>
                <p class="text-[var(--accent)] font-bold text-sm mb-3">نمونه‌کارها</p>
                <h2 class="text-3xl md:text-4xl font-extrabold">آخرین پروژه‌ها</h2>
            </div>
            {{--        <p class="text-sm text-[var(--muted)] max-w-xs">چند نمونه از پروژه‌هایی که از صفر تا استقرار روی سرور، خودم توسعه دادم.</p>--}}
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            @foreach ($projects as $project)
                @if ($project['is_featured'] ?? $project->featured)
                    <a href="https://{{ $project->url }}" target="_blank"
                       class="reveal proj-card mock-frame md:col-span-2 group">
                        <div class="mock-bar flex items-center gap-1.5 px-4 py-3">
                            <span class="mock-dot bg-[#FF6159]"></span>
                            <span class="mock-dot bg-[#FFC02E]"></span>
                            <span class="mock-dot bg-[#28C93F]"></span>
                            <span class="mono text-[10px] text-[var(--muted)] mr-3" dir="ltr">{{ $project->url }}</span>
                            <span class="mr-auto flex items-center gap-1.5 text-[10px] font-bold text-[#1FA971]">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#1FA971]"></span> LIVE
                </span>
                        </div>
                        <div class="grid md:grid-cols-2">
                            <div class="proj-img thumb-4 h-54 md:h-auto">
                                <div class="art absolute inset-0 flex items-center justify-center">
                                    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}">
                                </div>
                                <div class="overlay">
                        <span class="text-white text-sm font-bold flex items-center gap-2">
                            مشاهده پروژه <span class="group-hover:-translate-x-1 transition-transform">←</span></span>
                                </div>
                            </div>
                            <div class="p-8 md:p-10 flex flex-col justify-center">
                                <span class="text-xs font-bold text-[var(--accent)] mb-3">پروژه ویژه</span>
                                <h3 class="text-2xl font-extrabold mb-3 group-hover:text-[var(--accent)] transition-colors">{{ $project->title }}</h3>
                                <p class="text-sm text-[var(--muted)] leading-7 mb-6">{{ $project->description }}</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="tag font-bold px-3 py-1.5 rounded-full">Laravel</span>
                                    <span class="tag font-bold px-3 py-1.5 rounded-full">Livewire</span>
                                    <span class="tag font-bold px-3 py-1.5 rounded-full">MySQL</span>
                                    <span class="tag font-bold px-3 py-1.5 rounded-full">Tailwind</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <a href="https://{{ $project->url }}" target="_blank" class="reveal proj-card mock-frame group">
                        <div class="mock-bar flex items-center gap-1.5 px-4 py-3">
                            <span class="mock-dot bg-[#FF6159]"></span>
                            <span class="mock-dot bg-[#FFC02E]"></span>
                            <span class="mock-dot bg-[#28C93F]"></span>
                            <span class="mono text-[10px] text-[var(--muted)] mr-3" dir="ltr">{{ $project->url }}</span>
                            <span class="mr-auto flex items-center gap-1.5 text-[10px] font-bold text-[#1FA971]">
                      <span class="w-1.5 h-1.5 rounded-full bg-[#1FA971]"></span> LIVE
                    </span>
                        </div>
                        <div class="proj-img thumb-3 h-52">
                            <div class="art absolute inset-0 flex items-center justify-center">
                                <img src="{{ asset($project->image) }}" alt="{{ $project->title }}">
                            </div>
                            <div class="overlay">
                                <span class="text-white text-sm font-bold flex items-center gap-2">مشاهده پروژه <span
                                        class="group-hover:-translate-x-1 transition-transform">←</span></span>
                            </div>
                        </div>
                        <div class="p-6">
                            {{--                <span class="mono text-[10px] text-[var(--muted-2)]">02</span>--}}
                            <h3 class="text-lg font-extrabold mb-2 mt-1 group-hover:text-[var(--accent)] transition-colors">{{ $project->title }}</h3>
                            <p class="text-sm text-[var(--muted)] leading-6 mb-4">{{ $project->description }}</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="tag font-bold px-3 py-1.5 rounded-full">Laravel</span>
                                <span class="tag font-bold px-3 py-1.5 rounded-full">Livewire</span>
                                <span class="tag font-bold px-3 py-1.5 rounded-full">MySQL</span>
                                <span class="tag font-bold px-3 py-1.5 rounded-full">Tailwind</span>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>

        {{--    <div class="reveal flex justify-center mt-10">--}}
        {{--        <a href="#" class="border border-[var(--border)] px-7 py-3 rounded-full font-bold text-sm hover:bg-[var(--bg-soft)] transition-colors">مشاهده همه پروژه‌ها</a>--}}
        {{--    </div>--}}
    </section>

    <!-- STATS -->
    <section class="bg-[var(--bg-soft)] py-14 mb-4">
        <div class="max-w-[1320px] mx-auto px-6 lg:px-14 grid grid-cols-3 gap-6 text-center">
            <div class="reveal">
                <p class="text-3xl md:text-4xl font-extrabold text-[var(--accent)] mb-1">۵۰+</p>
                <p class="text-sm text-[var(--muted)]">پروژه‌ی موفق</p>
            </div>
            <div class="reveal">
                <p class="text-3xl md:text-4xl font-extrabold text-[var(--accent)] mb-1">Laravel</p>
                <p class="text-sm text-[var(--muted)]">فریم‌ورک اصلی</p>
            </div>
            <div class="reveal">
                <p class="text-3xl md:text-4xl font-extrabold text-[var(--accent)] mb-1">Livewire</p>
                <p class="text-sm text-[var(--muted)]">لایه رابط کاربری</p>
            </div>
        </div>
    </section>

    <!-- LATEST ARTICLES (matches blog card style) -->
    <section id="articles" class="max-w-[1320px] mx-auto px-6 lg:px-14 py-16">
        <div class="reveal flex items-end justify-between flex-wrap gap-4 mb-12">
            <div>
                <p class="text-[var(--accent)] font-bold text-sm mb-3">مقالات تخصصی</p>
                <h2 class="text-3xl md:text-4xl font-extrabold">آخرین مقالات تخصصی</h2>
            </div>
            <a href="{{ url('blog') }}" class="text-sm font-bold text-[var(--accent)]">مشاهده همه ←</a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($blogs as $blog)
                <a href="{{ route('blog.single',$blog->id) }}">
                    <article class="reveal card overflow-hidden">
                        <div class="h-40 thumb-1 flex items-center justify-center">
                            <img src="{{ asset( $blog->image ) }}" alt="">
                        </div>
                        <div class="p-5 mt-3">
                            <span class="pill text-xs font-bold px-3 py-1 rounded-full">تکنولوژی</span>
                            <span
                                class="text-xs text-[var(--muted)] float-left mt-2">{{ \Morilog\Jalali\Jalalian::fromCarbon($blog->created_at)->format('Y-m-d') }}</span>
                            <h3 class="font-bold text-base leading-7 mt-4 clear-both">{{ $blog->title }}</h3>
                            <span class="text-sm text-[var(--muted)] leading-7 mb-6">{{ $blog->summary }}</span>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="max-w-[1320px] mx-auto px-6 lg:px-14 py-20 scroll-mt-20">
        <div class="grid md:grid-cols-2 gap-14 items-center">
            <div class="reveal text-center md:text-right">
                <p class="text-[var(--accent)] font-bold text-sm mb-3">راه‌های ارتباطی</p>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-5 leading-[1.4]">بیایید پروژه‌ی بعدی‌تان را شروع
                    کنیم</h2>
                <p class="text-[var(--muted)] leading-8 max-w-md mx-auto md:mx-0 mb-9">از هر کدام از راه‌های کنار
                    می‌توانید با من در ارتباط باشید؛ معمولاً کمتر از یک روز کاری پاسخ می‌دهم.</p>
                <a href="mailto:{{ setting('site_email') }}"
                   class="btn-primary inline-block text-white px-8 py-3.5 rounded-full font-bold text-sm">ارسال ایمیل
                    مستقیم</a>
            </div>

            <div class="reveal mock-frame shadow-xl">
                <div class="mock-bar flex items-center gap-1.5 px-4 py-3">
                    <span class="mock-dot bg-[#FF6159]"></span>
                    <span class="mock-dot bg-[#FFC02E]"></span>
                    <span class="mock-dot bg-[#28C93F]"></span>
                    <span class="mono text-[10px] text-[var(--muted)] mr-3" dir="ltr">devprofile.ir/contact</span>
                </div>
                <div class="divide-y divide-[var(--border)]">
                    @php
                        $socials = \App\Models\Settings::where('group', 'social')->get();

                        $styleMap = [
                            'social_github' => [
                                'title' => 'گیت‌هاب',
                                'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.479C19.138 20.164 22 16.418 22 12c0-5.523-4.477-10-10-10z"/></svg>',
                                'bg' => 'bg-[#EFEFEF]',
                                'text' => 'text-[var(--ink)]'
                            ],
                            'social_linkedin' => [
                                'title' => 'لینکدین',
                                'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.6 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>',
                                'bg' => 'bg-[#E8F4FD]',
                                'text' => 'text-[#0A66C2]'
                            ],
                            'social_instagram' => [
                                'title' => 'اینستاگرام',
                                'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
                                'bg' => 'bg-[#FDF0F5]',
                                'text' => 'text-[#E1306C]'
                            ],
                            'social_youtube' => [
                                'title' => 'یوتیوب',
                                'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                                'bg' => 'bg-[#FCE8E6]',
                                'text' => 'text-[#FF0000]'
                            ],
                        ];
                    @endphp
                    @foreach($socials as $social)
                        @php
                            // اگر استایلی در مپ نبود، یک استایل پیش‌فرض اختصاص داده می‌شود
                            $style = $styleMap[$social->key] ?? ['title' => 'شبکه اجتماعی', 'icon' => '🌐', 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'];

                            // پاک کردن https:// برای نمایش تمیزتر آدرس
                            $displayUrl = str_replace(['https://', 'http://', 'www.'], '', $social->value);
                        @endphp

                        <a href="{{ $social->value }}" target="_blank" rel="noopener"
                           class="flex items-center gap-4 px-6 py-5 hover:bg-[var(--bg-soft)] transition-colors group">
                            <div
                                class="w-10 h-10 rounded-xl {{ $style['bg'] }} {{ $style['text'] }} flex items-center justify-center text-base shrink-0">
                                {!! $style['icon'] !!}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-sm">{{ $style['title'] }}</p>
                                <p class="text-xs text-[var(--muted)]" dir="ltr">{{ $displayUrl }}</p>
                            </div>
                            <span
                                class="text-[var(--muted-2)] group-hover:text-[var(--accent)] group-hover:-translate-x-1 transition-all">←</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
