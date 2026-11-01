@extends('partials.layout')

@push('head')
    <style>
        #home, #services, #portfolio, #about, #process, #testimonials, #blog, #contact { scroll-margin-top: 80px; }

        /* --- contact card --- */
        .contact-card{
            background:
                radial-gradient(120% 130% at 85% 0%, rgba(99,102,241,.38), transparent 58%),
                radial-gradient(110% 120% at 0% 100%, rgba(34,211,238,.16), transparent 55%),
                linear-gradient(160deg, #0d0b26 0%, #15123c 48%, #0a0918 100%);
        }
        .contact-grid{
            background-image:
                linear-gradient(to right, rgba(255,255,255,.055) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,.055) 1px, transparent 1px);
            background-size: 48px 48px;
            -webkit-mask-image: radial-gradient(ellipse 85% 75% at 50% 40%, #000 25%, transparent 78%);
                    mask-image: radial-gradient(ellipse 85% 75% at 50% 40%, #000 25%, transparent 78%);
        }
        .contact-orb{ animation: contact-float 11s ease-in-out infinite; }
        .contact-orb--slow{ animation-duration: 15s; animation-direction: reverse; }
        @keyframes contact-float{
            0%,100%{ transform: translate3d(0,0,0) scale(1); }
            50%{ transform: translate3d(0,-26px,0) scale(1.06); }
        }
        @media (prefers-reduced-motion: reduce){
            .contact-orb{ animation: none; }
        }
    </style>
    <noscript>
        <style>
            .reveal { opacity: 1 !important; transform: none !important; }
        </style>
    </noscript>
@endpush

@section('main')
    @php
        $phone = setting('site_phone');
        $email = setting('site_email');
        $address = setting('site_address');

        $contactSocials = array_values(array_filter([
            [
                'title' => 'گیت‌هاب',
                'href' => setting('social_github'),
                'icon' => '<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.479C19.138 20.164 22 16.418 22 12c0-5.523-4.477-10-10-10z"/>',
            ],
            [
                'title' => 'لینکدین',
                'href' => setting('social_linkedin'),
                'icon' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.6 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/>',
            ],
            [
                'title' => 'اینستاگرام',
                'href' => setting('social_instagram'),
                'icon' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>',
            ],
            [
                'title' => 'یوتیوب',
                'href' => setting('social_youtube'),
                'icon' => '<path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>',
            ],
        ], fn ($social) => filled($social['href'])));

        $fallbackProjects = [
            ['title' => 'سایت شخصی‌ارزومه', 'description' => 'طراحی سایت رزومه و معرفی مهارت‌ها', 'tag' => 'طراحی سایت', 'gradient' => 'from-purple-900 to-fuchsia-600'],
            ['title' => 'پروژه سئو فروشگاهی', 'description' => 'افزایش رتبه در گوگل و رشد ترافیک ارگانیک', 'tag' => 'سئو', 'gradient' => 'from-slate-100 to-indigo-100'],
            ['title' => 'سایت شرکتی صنعتی', 'description' => 'طراحی و توسعه سایت شرکتی با پنل مدیریت', 'tag' => 'طراحی سایت', 'gradient' => 'from-slate-900 to-slate-700'],
        ];

        $fallbackBlogs = [
            ['title' => 'راهنمای کامل سئو برای سایت‌های تازه‌کار', 'date' => '۱۴۰۴/۰۴/۲۸', 'gradient' => 'from-slate-900 to-brand-700'],
            ['title' => '۵ اشتباه رایج در طراحی سایت که باید از آن‌ها اجتناب کرد', 'date' => '۱۴۰۴/۰۴/۲۴', 'gradient' => 'from-stone-400 to-stone-700'],
            ['title' => 'چگونه از هوش مصنوعی در سئو استفاده کنیم؟', 'date' => '۱۴۰۴/۰۴/۲۵', 'gradient' => 'from-cyan-700 to-slate-900'],
        ];
    @endphp

    {{-- ============ HERO ============ --}}
    <section id="home" class="relative overflow-hidden bg-gradient-to-b from-brand-50/60 to-white">
        <div class="max-w-6xl mx-auto px-4 py-12 md:py-24 grid md:grid-cols-2 gap-10 md:gap-12 items-center">
            <div class="reveal">
                <span class="inline-block text-xs bg-brand-50 text-brand-600 rounded-md px-3 py-1 mb-5">طراحی سایت، سئو و توسعه وب</span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-snug text-slate-900">
                    سایتی حرفه‌ای،<br>
                    با طراحی مدرن و <span class="text-brand-600">سئوی اصولی</span>
                </h1>
                <p class="mt-5 text-sm sm:text-base text-slate-500 leading-8 max-w-md">
                    با تجربه طراحی سایت و سئو، به شما کمک می‌کنم تا کسب‌وکار آنلاین خود را به بهترین شکل راه‌اندازی کنید و در گوگل دیده شوید.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row flex-wrap gap-3">
                    <a href="#contact" class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium rounded-xl px-6 py-3 shadow-lg shadow-brand-500/30 transition">
                        مشاوره و شروع پروژه
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="#portfolio" class="inline-flex items-center justify-center gap-2 bg-white border border-slate-200 hover:border-brand-500 text-slate-700 text-sm font-medium rounded-xl px-6 py-3 transition">
                        مشاهده نمونه‌کارها
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
                <div class="mt-8 flex flex-wrap gap-2.5 text-xs text-slate-500">
                    <span class="flex items-center gap-2 bg-white border border-slate-100 rounded-xl px-3.5 py-2.5">⏱ تحویل به موقع</span>
                    <span class="flex items-center gap-2 bg-white border border-slate-100 rounded-xl px-3.5 py-2.5">🎧 پشتیبانی واقعی</span>
                    <span class="flex items-center gap-2 bg-white border border-slate-100 rounded-xl px-3.5 py-2.5">🛡 قیمت منصفانه</span>
                </div>
            </div>

            {{-- Hero visual --}}
            <div class="hidden lg:grid reveal relative h-64 sm:h-72 md:h-96" style="transition-delay: 120ms">
                <img src="/Hero-Mockup.png" alt="">
                <div class="absolute top-0 left-0 sm:left-4 bg-white rounded-xl shadow-xl px-3 py-2 sm:px-4 sm:py-3 text-[11px] sm:text-xs flex items-center gap-2">
                    <span class="text-green-500 text-base sm:text-lg">↗</span>
                    <div><b class="block">SEO</b><span class="text-slate-400">رتبه بهتر در گوگل</span></div>
                </div>
                <div class="absolute bottom-0 right-0 sm:right-4 bg-white rounded-xl shadow-xl px-3 py-2 sm:px-4 sm:py-3 text-[11px] sm:text-xs flex items-center gap-2">
                    <span class="font-bold">+۵۰</span> پروژه‌های موفق
                </div>
            </div>
        </div>
    </section>

    {{-- ============ SERVICES ============ --}}
    <section id="services" class="py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <span class="reveal inline-block text-xs bg-brand-50 text-brand-600 rounded-md px-3 py-1">خدمات ما</span>
            <h2 class="reveal mt-4 text-xl sm:text-2xl md:text-3xl font-extrabold" style="transition-delay: 60ms">راهکارهای کامل برای حضور حرفه‌ای در وب</h2>
            <p class="reveal mt-3 text-xs sm:text-sm text-slate-400" style="transition-delay: 120ms">از طراحی سایت گرفته تا سئو و بهینه‌سازی، همه چیز برای رشد کسب‌وکار شما.</p>

            <div class="mt-8 md:mt-10 grid grid-cols-2 lg:grid-cols-4 gap-4 text-right">
                <div class="reveal rounded-2xl border border-rose-100 bg-rose-50/50 p-5" style="transition-delay: 60ms">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 grid place-items-center text-rose-500">▤</div>
                    <h3 class="mt-4 font-bold text-sm">مدیریت محتوا</h3>
                    <p class="mt-2 text-xs text-slate-400 leading-6">راه‌اندازی و مدیریت سیستم مدیریت محتوای سایت شما.</p>
                    <span class="mt-4 w-8 h-8 rounded-full border border-rose-200 text-rose-500 grid place-items-center">←</span>
                </div>
                <div class="reveal rounded-2xl border border-sky-100 bg-sky-50/50 p-5" style="transition-delay: 180ms">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 grid place-items-center text-sky-500">☁</div>
                    <h3 class="mt-4 font-bold text-sm">توسعه وب</h3>
                    <p class="mt-2 text-xs text-slate-400 leading-6">توسعه اختصاصی و شخصی‌سازی برنامه‌های وب.</p>
                    <span class="mt-4 w-8 h-8 rounded-full border border-sky-200 text-sky-500 grid place-items-center">←</span>
                </div>
                <div class="reveal rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5" style="transition-delay: 240ms">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 grid place-items-center text-indigo-500">&lt;/&gt;</div>
                    <h3 class="mt-4 font-bold text-sm">طراحی سایت</h3>
                    <p class="mt-2 text-xs text-slate-400 leading-6">طراحی سایت‌های مدرن، سریع و کاملاً اختصاصی.</p>
                    <span class="mt-4 w-8 h-8 rounded-full border border-indigo-200 text-indigo-500 grid place-items-center">←</span>
                </div>
                <div class="reveal rounded-2xl border border-emerald-100 bg-emerald-50/50 p-5" style="transition-delay: 300ms">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 grid place-items-center text-emerald-500">⌕</div>
                    <h3 class="mt-4 font-bold text-sm">سئو</h3>
                    <p class="mt-2 text-xs text-slate-400 leading-6">بهینه‌سازی سایت برای رتبه‌های بالاتر در گوگل.</p>
                    <span class="mt-4 w-8 h-8 rounded-full border border-emerald-200 text-emerald-500 grid place-items-center">←</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ PORTFOLIO ============ --}}
    <section id="portfolio" class="py-12 md:py-16 bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-[1fr_2fr] gap-8 items-center">
            <div class="reveal">
                <span class="text-xs bg-brand-50 text-brand-600 rounded-md px-3 py-1">نمونه‌کارهای ما</span>
                <h2 class="mt-4 text-xl sm:text-2xl font-extrabold">پروژه‌های اخیر</h2>
                <p class="mt-3 text-sm text-slate-400 leading-7">برخی از نمونه‌کارهای انجام شده در زمینه طراحی سایت، سئو و توسعه وب را مشاهده کنید.</p>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
                @forelse ($projects as $project)
                    <article class="reveal bg-white rounded-2xl p-3 shadow-sm" style="transition-delay: {{ $loop->index * 90 }}ms">
                        <div class="relative h-36 rounded-xl overflow-hidden bg-gradient-to-br from-slate-100 to-indigo-100">
                            @if ($project->image)
                                <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                            @endif
                            <span class="absolute bottom-2 right-2 text-[10px] bg-white text-brand-600 rounded px-2 py-0.5">پروژه</span>
                        </div>
                        <h3 class="mt-3 text-sm font-bold">
                            @if ($project->url)
                                <a href="{{ $project->url }}" target="_blank" rel="noopener" class="hover:text-brand-600 transition">{{ $project->title }}</a>
                            @else
                                {{ $project->title }}
                            @endif
                        </h3>
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $project->description }}</p>
                    </article>
                @empty
                    @foreach ($fallbackProjects as $project)
                        <article class="reveal bg-white rounded-2xl p-3 shadow-sm" style="transition-delay: {{ $loop->index * 90 }}ms">
                            <div class="relative h-36 rounded-xl bg-gradient-to-br {{ $project['gradient'] }}">
                                <span class="absolute bottom-2 right-2 text-[10px] bg-white text-brand-600 rounded px-2 py-0.5">{{ $project['tag'] }}</span>
                            </div>
                            <h3 class="mt-3 text-sm font-bold">{{ $project['title'] }}</h3>
                            <p class="text-xs text-slate-400 mt-1">{{ $project['description'] }}</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============ WHY ME ============ --}}
    <section id="about" class="py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="reveal rounded-3xl bg-slate-50 p-6 sm:p-8 grid lg:grid-cols-3 gap-8 items-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 order-3 lg:order-none">
                    <div class="flex gap-3"><span class="w-9 h-9 shrink-0 rounded-full bg-brand-50 text-brand-600 grid place-items-center">★</span><div><h4 class="text-sm font-bold">تجربه کاری بالا</h4><p class="text-xs text-slate-400 mt-1 leading-6">سال‌ها تجربه در طراحی سایت و سئو.</p></div></div>
                    <div class="flex gap-3"><span class="w-9 h-9 shrink-0 rounded-full bg-brand-50 text-brand-600 grid place-items-center">⚡</span><div><h4 class="text-sm font-bold">تسلط بر ابزارهای مدرن</h4><p class="text-xs text-slate-400 mt-1 leading-6">استفاده از جدیدترین تکنولوژی‌ها.</p></div></div>
                    <div class="flex gap-3"><span class="w-9 h-9 shrink-0 rounded-full bg-brand-50 text-brand-600 grid place-items-center">🎧</span><div><h4 class="text-sm font-bold">پشتیبانی واقعی</h4><p class="text-xs text-slate-400 mt-1 leading-6">پاسخگویی سریع و همراهی حتی بعد از تحویل.</p></div></div>
                    <div class="flex gap-3"><span class="w-9 h-9 shrink-0 rounded-full bg-brand-50 text-brand-600 grid place-items-center">↗</span><div><h4 class="text-sm font-bold">رعایت اصول سئو</h4><p class="text-xs text-slate-400 mt-1 leading-6">سایت‌های بهینه و آماده رشد در گوگل.</p></div></div>
                </div>
                <div>
                    <span class="text-xs bg-white text-brand-600 border border-slate-100 rounded-md px-3 py-1">چرا من؟</span>
                    <h2 class="mt-4 text-xl sm:text-2xl font-extrabold">تجربه، تخصص، تعهد</h2>
                    <p class="mt-3 text-sm text-slate-400 leading-7">با تمرکز بر کیفیت، تجربه کاربری و سئو، پروژه‌های شما را با دقت، سرعت و تعهد کامل انجام می‌دهم.</p>
                </div>
                <div class="hidden lg:grid place-items-center h-48 rounded-2xl bg-gradient-to-br from-brand-100 to-white text-6xl">
                    <img src="/developer.png" alt="">
                </div>
            </div>
        </div>
    </section>

    {{-- ============ PROCESS ============ --}}
    <section id="process" class="py-12 md:py-16 bg-brand-50/40">
        <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-[1fr_2.5fr] gap-8 md:gap-10 items-center">
            <div class="reveal">
                <span class="text-xs text-brand-600">فرآیند کار</span>
                <h2 class="mt-2 text-lg sm:text-xl font-extrabold">از ایده تا اجرا، در چند قدم ساده</h2>
                <p class="mt-3 text-sm text-slate-400 leading-7">با یک برنامه‌ریزی دقیق، پروژه شما بدون دردسر و در زمان توافق‌شده تحویل داده می‌شود.</p>
            </div>
            <ol class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <li class="reveal bg-white rounded-2xl p-5 shadow-sm" style="transition-delay: 60ms"><div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 grid place-items-center">💬</div><h3 class="mt-3 text-sm font-bold">مشاوره و بررسی نیازها</h3><p class="mt-1 text-xs text-slate-400 leading-6">بررسی دقیق نیازها و ارائه بهترین راهکار.</p></li>
                <li class="reveal bg-white rounded-2xl p-5 shadow-sm" style="transition-delay: 120ms"><div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 grid place-items-center">&lt;/&gt;</div><h3 class="mt-3 text-sm font-bold">طراحی و توسعه</h3><p class="mt-1 text-xs text-slate-400 leading-6">شروع طراحی و توسعه با گزارش روند کار.</p></li>
                <li class="reveal bg-white rounded-2xl p-5 shadow-sm" style="transition-delay: 180ms"><div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 grid place-items-center">✓</div><h3 class="mt-3 text-sm font-bold">تست و بررسی نهایی</h3><p class="mt-1 text-xs text-slate-400 leading-6">اطمینان از کیفیت، سرعت و سئو.</p></li>
                <li class="reveal bg-white rounded-2xl p-5 shadow-sm" style="transition-delay: 240ms"><div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 grid place-items-center">🚀</div><h3 class="mt-3 text-sm font-bold">تحویل و پشتیبانی</h3><p class="mt-1 text-xs text-slate-400 leading-6">تحویل پروژه و پشتیبانی پس از اجرا.</p></li>
            </ol>
        </div>
    </section>

    {{-- ============ TESTIMONIALS ============ --}}
    {{-- <section id="testimonials" class="py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-[2.5fr_1fr] gap-8 md:gap-10 items-center">
            <div class="grid sm:grid-cols-3 gap-4 order-2 lg:order-1">
                <figure class="reveal rounded-2xl border border-slate-100 p-5 shadow-sm" style="transition-delay: 60ms">
                    <blockquote class="text-xs text-slate-500 leading-6">سایت ما با کمک شما رشد داشته و در گوگل رتبه خوبی می‌گیرد.</blockquote>
                    <figcaption class="mt-4 flex items-center gap-3"><span class="w-9 h-9 rounded-full bg-slate-200"></span><div><b class="text-xs block">محمد رضایی</b><span class="text-[10px] text-slate-400">مدیر استارتاپ</span></div></figcaption>
                </figure>
                <figure class="reveal rounded-2xl border border-slate-100 p-5 shadow-sm" style="transition-delay: 120ms">
                    <blockquote class="text-xs text-slate-500 leading-6">تخصص و پشتیبانی عالی، پیشنهاد می‌کنم.</blockquote>
                    <figcaption class="mt-4 flex items-center gap-3"><span class="w-9 h-9 rounded-full bg-slate-200"></span><div><b class="text-xs block">سارا احمدی</b><span class="text-[10px] text-slate-400">بیزینس کوچ</span></div></figcaption>
                </figure>
                <figure class="reveal rounded-2xl border border-slate-100 p-5 shadow-sm" style="transition-delay: 180ms">
                    <blockquote class="text-xs text-slate-500 leading-6">کاری حرفه‌ای، دقیق و با کیفیت. کاملاً راضی هستم.</blockquote>
                    <figcaption class="mt-4 flex items-center gap-3"><span class="w-9 h-9 rounded-full bg-slate-200"></span><div><b class="text-xs block">علی محمدی</b><span class="text-[10px] text-slate-400">مدیر فروشگاه آنلاین</span></div></figcaption>
                </figure>
            </div>
            <div class="reveal order-1 lg:order-2">
                <span class="text-xs text-brand-600">نظرات شما</span>
                <h2 class="mt-2 text-lg sm:text-xl font-extrabold">اعتماد شما، بزرگ‌ترین انگیزه ماست</h2>
                <p class="mt-2 text-sm text-slate-400">رضایت مشتریان، بهترین گواه کیفیت کار ماست.</p>
            </div>
        </div>
    </section> --}}

    {{-- ============ BLOG ============ --}}
    <section id="blog" class="pb-12 md:pb-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="reveal flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                <div>
                    <span class="text-xs text-brand-600">مقالات و آموزش‌ها</span>
                    <h2 class="mt-2 text-lg sm:text-xl font-extrabold">آخرین مقالات و نکات کاربردی</h2>
                </div>
                <a href="{{ url('blog') }}" class="text-xs text-brand-600 shrink-0">مشاهده همه مقالات ←</a>
            </div>
            <div class="mt-6 md:mt-8 grid sm:grid-cols-3 gap-5">
                @forelse ($blogs as $blog)
                    <article class="reveal rounded-2xl overflow-hidden border border-slate-100 shadow-sm" style="transition-delay: {{ $loop->index * 90 }}ms">
                        <a href="{{ $blog->routeUrl() }}" class="block group">
                            <div class="relative h-32 bg-gradient-to-br from-slate-900 to-brand-700">
                                @if ($blog->image)
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                @endif
                                <span class="absolute bottom-2 left-2 text-[10px] bg-white text-brand-600 rounded px-2 py-0.5">مقاله</span>
                            </div>
                            <div class="p-4">
                                <h3 class="text-xs font-bold leading-6 line-clamp-2 group-hover:text-brand-600 transition">{{ $blog->title }}</h3>
                                <time class="text-[10px] text-slate-400">{{ jalali_date($blog->created_at) }}</time>
                            </div>
                        </a>
                    </article>
                @empty
                    @foreach ($fallbackBlogs as $blog)
                        <article class="reveal rounded-2xl overflow-hidden border border-slate-100 shadow-sm" style="transition-delay: {{ $loop->index * 90 }}ms">
                            <div class="relative h-32 bg-gradient-to-br {{ $blog['gradient'] }}">
                                <span class="absolute bottom-2 left-2 text-[10px] bg-white text-brand-600 rounded px-2 py-0.5">مقاله</span>
                            </div>
                            <div class="p-4"><h3 class="text-xs font-bold leading-6">{{ $blog['title'] }}</h3><time class="text-[10px] text-slate-400">{{ $blog['date'] }}</time></div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============ CONTACT ============ --}}
    <section id="contact" class="py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="reveal contact-card relative overflow-hidden rounded-[2rem] border border-white/10 shadow-2xl shadow-indigo-950/30 before:pointer-events-none before:absolute before:inset-x-12 before:top-0 before:h-px before:bg-gradient-to-l before:from-transparent before:via-white/40 before:to-transparent">
                {{-- decor --}}
                <div class="contact-grid pointer-events-none absolute inset-0"></div>
                <div class="contact-orb pointer-events-none absolute -top-32 -right-24 h-80 w-80 rounded-full bg-brand-500/40 blur-[100px]"></div>
                <div class="contact-orb contact-orb--slow pointer-events-none absolute -bottom-40 -left-24 h-96 w-96 rounded-full bg-cyan-400/20 blur-[110px]"></div>

                <div class="relative grid gap-8 p-6 sm:p-9 md:p-12 lg:grid-cols-[1.05fr_.95fr] lg:gap-12 lg:items-center">
                    {{-- copy + CTA --}}
                    <div class="min-w-0 text-center lg:text-right">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 text-[11px] font-bold text-white/90 backdrop-blur">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            </span>
                            آماده پذیرش پروژه‌های جدید
                        </span>

                        <h2 class="mt-5 text-2xl font-extrabold leading-snug text-white text-balance sm:text-3xl md:text-[2.35rem]">
                            ایده‌ات را بگو،
                            <span class="block bg-gradient-to-l from-sky-300 via-brand-200 to-white bg-clip-text text-transparent sm:inline-block">با هم می‌سازیمش</span>
                        </h2>
                        <p class="mx-auto mt-4 max-w-md text-sm leading-7 text-white/60 lg:mx-0">
                            برای مشاوره و شروع پروژه کافیست تماس بگیرید؛ معمولاً کمتر از یک روز کاری پاسخ می‌دهم.
                        </p>

                        <div class="mt-7 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:items-center lg:justify-start">
                            @if ($phone)
                                <a href="tel:{{ $phone }}"
                                   class="group inline-flex items-center justify-center gap-2.5 rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-[#11132B] shadow-xl shadow-black/25 transition hover:-translate-y-0.5 hover:bg-brand-50 hover:shadow-brand-500/25">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.24 1L8.2 10.7a11 11 0 005.1 5.1l1.52-1.29a1 1 0 011-.24l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.6 21 3 14.4 3 6V5z"/>
                                    </svg>
                                    تماس تلفنی
                                </a>
                            @endif
                            @if ($email)
                                <a href="mailto:{{ $email }}"
                                   class="group inline-flex items-center justify-center gap-2.5 rounded-2xl border border-white/20 bg-white/[0.06] px-6 py-3.5 text-sm font-bold text-white backdrop-blur transition hover:-translate-y-0.5 hover:border-white/35 hover:bg-white/[0.12]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.9 5.27a2 2 0 002.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    ارسال ایمیل
                                </a>
                            @endif
                        </div>

                        @if (count($contactSocials))
                            <div class="mt-8 flex flex-col items-center justify-center gap-3 border-t border-white/10 pt-6 sm:flex-row lg:justify-start">
                                <span class="text-[11px] text-white/40">من را در شبکه‌های اجتماعی دنبال کنید</span>
                                <div class="flex gap-2">
                                    @foreach ($contactSocials as $social)
                                        <a href="{{ $social['href'] }}" target="_blank" rel="noopener" title="{{ $social['title'] }}" aria-label="{{ $social['title'] }}"
                                           class="grid h-9 w-9 place-items-center rounded-xl border border-white/10 bg-white/5 text-white/70 transition hover:-translate-y-0.5 hover:border-transparent hover:bg-white hover:text-[#11132B]">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">{!! $social['icon'] !!}</svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- contact info --}}
                    <div class="mx-auto w-full min-w-0 max-w-md space-y-3 lg:mx-0 lg:max-w-none">
                        @if ($phone)
                            <a href="tel:{{ $phone }}"
                               class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-white/25 hover:bg-white/[0.09]">
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-brand-500 to-indigo-500 text-white shadow-lg shadow-brand-900/50">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.24 1L8.2 10.7a11 11 0 005.1 5.1l1.52-1.29a1 1 0 011-.24l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.6 21 3 14.4 3 6V5z"/>
                                    </svg>
                                </span>
                                <span class="min-w-0 flex-1 text-right">
                                    <span class="block text-[11px] text-white/45">شماره تماس</span>
                                    <span class="mt-0.5 block truncate text-sm font-bold text-white" dir="ltr">{{ $phone }}</span>
                                </span>
                                <svg class="h-4 w-4 shrink-0 text-white/25 transition group-hover:-translate-x-0.5 group-hover:text-white/70 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                                </svg>
                            </a>
                        @endif

                        @if ($email)
                            <a href="mailto:{{ $email }}"
                               class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-white/25 hover:bg-white/[0.09]">
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-400 text-white shadow-lg shadow-sky-900/50">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.9 5.27a2 2 0 002.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <span class="min-w-0 flex-1 text-right">
                                    <span class="block text-[11px] text-white/45">ایمیل</span>
                                    <span class="mt-0.5 block break-words text-sm font-bold text-white" dir="ltr">{{ $email }}</span>
                                </span>
                                <svg class="h-4 w-4 shrink-0 text-white/25 transition group-hover:-translate-x-0.5 group-hover:text-white/70 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                                </svg>
                            </a>
                        @endif

                        @if ($address)
                            <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-white/20 hover:bg-white/[0.07]">
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-400 text-white shadow-lg shadow-emerald-900/50">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.25 7-11a7 7 0 10-14 0c0 5.75 7 11 7 11z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="block text-[11px] text-white/45">آدرس</span>
                                    <span class="mt-0.5 block text-sm font-bold leading-6 text-white">{{ $address }}</span>
                                </span>
                            </div>
                        @endif

                        <div class="flex items-center gap-3 rounded-2xl border border-dashed border-white/15 px-4 py-3.5 text-[11px] text-white/50">
                            <svg class="h-4 w-4 shrink-0 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                            </svg>
                            ساعت پاسخگویی: شنبه تا پنجشنبه، ۹ تا ۱۸
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
