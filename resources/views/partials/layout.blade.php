<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <title>{{ setting('site_title') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ setting('site_description') }}" name="description">
    <meta name="author" content="{{ setting('seo_meta_author') }}">
    <meta name="keywords" content="{{ setting('seo_meta_keywords') }}">
    <meta property="og:image" content={{ setting('seo_og_image') }}"">
    <link rel="icon" href="{{ setting('site_favicon') }}">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/js/app.js','resources/css/app.css'])
    <style>
        :root{
            --ink:#171923;
            --muted:#6B7280;
            --muted-2:#B4B7C4;
            --bg:#FFFFFF;
            --bg-soft:#F6F6FB;
            --accent:#4F39F6;
            --accent-soft:#EEECFF;
            --footer:#11132B;
            --border:#ECEDF3;
        }
        *{box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{ font-family:'Vazirmatn',sans-serif; background:var(--bg); color:var(--ink); }
        .mono{ font-family:'JetBrains Mono',monospace; }

        .card{
            background:#fff; border:1px solid var(--border); border-radius:18px;
            box-shadow:0 1px 2px rgba(17,19,43,.03);
            transition:transform .25s ease, box-shadow .25s ease;
        }
        .card:hover{ transform:translateY(-4px); box-shadow:0 16px 30px -12px rgba(17,19,43,.12); }

        .pill{ background:var(--accent-soft); color:var(--accent); }

        .thumb-1{ background:linear-gradient(135deg,#FF7A59,#FFB199); }
        .thumb-2{ background:linear-gradient(135deg,#4F39F6,#8B7CF6); }
        .thumb-3{ background:linear-gradient(135deg,#0EA5A5,#34D399); }
        .thumb-4{ background:linear-gradient(135deg,#171923,#3D4260); }

        .btn-primary{ background:var(--accent); transition:transform .2s ease, box-shadow .2s ease; box-shadow:0 10px 20px -8px rgba(79,57,246,.5); }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 14px 26px -8px rgba(79,57,246,.55); }

        /* --- header --- */
        .nav-link{ position:relative; }
        .nav-link::after{
            content:''; position:absolute; right:0; bottom:-22px; height:2px; width:0;
            background:var(--accent); transition:width .25s ease;
        }
        .nav-link:hover::after, .nav-link.active::after{ width:100%; }
        .nav-link.active{ color:var(--ink); }
        header.scrolled{ box-shadow:0 6px 24px -14px rgba(17,19,43,.18); }
        #mobileMenu{ max-height:0; overflow:hidden; transition:max-height .3s ease; }
        #mobileMenu.open{ max-height:280px; }
        .burger span{ transition:transform .25s ease, opacity .25s ease; }
        .burger.open span:nth-child(1){ transform:translateY(6px) rotate(45deg); }
        .burger.open span:nth-child(2){ opacity:0; }
        .burger.open span:nth-child(3){ transform:translateY(-6px) rotate(-45deg); }

        /* --- project mockups --- */
        .mock-frame{ background:#fff; border:1px solid var(--border); border-radius:20px; overflow:hidden; }
        .mock-bar{ background:#F2F2F8; border-bottom:1px solid var(--border); }
        .mock-dot{ width:8px; height:8px; border-radius:999px; }
        .tag{ background:#F2F2F8; color:var(--muted); font-size:11px; }
        .proj-img{ position:relative; overflow:hidden; }
        .proj-img .overlay{
            position:absolute; inset:0; background:linear-gradient(180deg, rgba(17,19,43,0) 40%, rgba(17,19,43,.75) 100%);
            opacity:0; transition:opacity .3s ease; display:flex; align-items:flex-end; padding:20px;
        }
        .proj-card:hover .overlay{ opacity:1; }
        .proj-card:hover .proj-img img, .proj-card:hover .proj-img .art{ transform:scale(1.04); }
        .proj-img .art{ transition:transform .5s ease; }

        /* --- hero visual --- */
        .blob{ filter:blur(50px); }
        @keyframes float{ 0%,100%{ transform:translateY(0) rotate(var(--r,0deg)); } 50%{ transform:translateY(-12px) rotate(var(--r,0deg)); } }
        .float-card{ animation: float 5s ease-in-out infinite; }
        .bar{ border-radius:6px; background:var(--bg-soft); }
        @keyframes barpulse{ 0%,100%{ opacity:.55; } 50%{ opacity:1; } }
        .bar-active{ animation: barpulse 2.4s ease-in-out infinite; }

        .reveal{ opacity:0; transform:translateY(16px); transition:opacity .55s ease, transform .55s ease; }
        .reveal.in{ opacity:1; transform:translateY(0); }

        ::selection{ background:var(--accent); color:#fff; }
        @media (prefers-reduced-motion: reduce){
            .reveal{ opacity:1; transform:none; transition:none; }
            .card{ transition:none; }
        }
    </style>
</head>
<body class="antialiased">

<!-- HEADER -->
<header id="siteHeader" class="sticky top-0 z-50 bg-white/85 backdrop-blur border-b border-[var(--border)] transition-shadow">
    <div class="max-w-[1320px] mx-auto px-6 lg:px-14 flex items-center justify-between h-[72px]">
        <a href="/" class="flex items-center gap-2.5 shrink-0">
            <div class="w-9 h-9 rounded-xl bg-[var(--ink)] flex items-center justify-center relative">
                <img src="{{ asset(setting('site_logo')) }}" alt="">
            </div>
            <span class="font-extrabold text-lg">Dev<span class="text-[var(--accent)]">Profile</span></span>
        </a>

        <nav class="hidden md:flex items-center gap-10 text-sm font-medium text-[var(--muted)]">
            <a href="{{ url('/') . '#skills'}}" class="nav-link hover:text-[var(--ink)] transition-colors py-1">مهارت‌ها</a>
            <a href="{{ url('/') .  '#projects'}}" class="nav-link hover:text-[var(--ink)] transition-colors py-1">پروژه‌ها</a>
            <a href="{{ url('/') .  '#articles'}}" class="nav-link hover:text-[var(--ink)] transition-colors py-1">مقالات</a>
            {{--            <a href="#about" class="nav-link hover:text-[var(--ink)] transition-colors py-1">درباره من</a>--}}
        </nav>

        <div class="flex items-center gap-3">
            {{--            <div class="hidden sm:flex items-center gap-1.5 pill text-xs font-bold px-3 py-1.5 rounded-full">--}}
            {{--                <span class="w-1.5 h-1.5 rounded-full bg-[var(--accent)]"></span>--}}
            {{--                در دسترس--}}
            {{--            </div>--}}
            <a href="{{ url('/') .  '#contact'}}" class="hidden md:inline-block btn-primary text-white text-sm font-bold px-5 py-2.5 rounded-full">شروع همکاری</a>
            <button id="burgerBtn" class="burger md:hidden w-9 h-9 flex flex-col items-center justify-center gap-[5px]" aria-label="باز کردن منو">
                <span class="block w-5 h-[2px] bg-[var(--ink)] rounded-full"></span>
                <span class="block w-5 h-[2px] bg-[var(--ink)] rounded-full"></span>
                <span class="block w-5 h-[2px] bg-[var(--ink)] rounded-full"></span>
            </button>
        </div>
    </div>

    <div id="mobileMenu" class="md:hidden border-t border-[var(--border)]">
        <nav class="flex flex-col px-6 py-4 gap-1 text-sm font-medium">
            <a href="{{ url('/') .  '#skills'}}" class="py-2.5 text-[var(--muted)] hover:text-[var(--ink)]">مهارت‌ها</a>
            <a href="{{ url('/') .  '#projects'}}" class="py-2.5 text-[var(--ink)] hover:text-[var(--ink)]">پروژه‌ها</a>
            <a href="{{ url('/') .  '#articles'}}" class="py-2.5 text-[var(--muted)] hover:text-[var(--ink)]">مقالات</a>
            {{--            <a href="#about" class="py-2.5 text-[var(--muted)] hover:text-[var(--ink)]">درباره من</a>--}}
            <a href="{{ url('/') .  '#contact'}}" class="btn-primary text-white text-sm font-bold px-5 py-3 rounded-full text-center mt-2">شروع همکاری</a>
        </nav>
    </div>
</header>

@yield('main')'

<footer class="bg-slate-900 text-white py-12">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-10">
        <div>
            <div class="text-3xl font-black italic mb-2 text-center">
                <a href="{{ url('/') }}">
                    Dev<span class="text-indigo-500">Profile</span>.ir
                </a>
            </div>
            <p class="text-slate-500 text-sm">تمامی حقوق برای این برند محفوظ است. ۲۰۲۶</p>
        </div>
        <div class="flex gap-4">
            <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center hover:bg-white/10 transition cursor-pointer">
                <a href="{{ setting('social_github') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.479C19.138 20.164 22 16.418 22 12c0-5.523-4.477-10-10-10z"/>
                    </svg>
                </a>
            </div>
            <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center hover:bg-indigo-600 transition cursor-pointer">
                <a href="{{ setting('social_instagram') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </a>
            </div>
            <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center hover:bg-white/10 transition cursor-pointer">
                <a href="{{ setting('social_youtube') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>

<script>
    const els = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver((entries)=>{
        entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); } });
    }, {threshold:.15});
    els.forEach(el=>io.observe(el));

    // mobile menu
    const burgerBtn = document.getElementById('burgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    burgerBtn.addEventListener('click', ()=>{
        burgerBtn.classList.toggle('open');
        mobileMenu.classList.toggle('open');
    });
    mobileMenu.querySelectorAll('a').forEach(a=> a.addEventListener('click', ()=>{
        burgerBtn.classList.remove('open');
        mobileMenu.classList.remove('open');
    }));

    // header shadow on scroll
    const header = document.getElementById('siteHeader');
    window.addEventListener('scroll', ()=>{
        header.classList.toggle('scrolled', window.scrollY > 8);
    });
</script>
</body>
</html>
