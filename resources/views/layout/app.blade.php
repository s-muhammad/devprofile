<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site_title') }}</title>
    <style>

        /* 1. تنظیم مجدد موقعیت و فاصله برای نمایش زیر کارت‌ها */
        .swiper-pagination {
            /* موقعیت پیش‌فرض bottom: 0 است، با تنظیم margin-top آن را پایین می‌بریم */
            margin-top: 20px !important;
            /* اگر این کار نکرد، از bottom و position: relative استفاده کنید */
            position: relative !important;
            bottom: -20px !important; /* فاصله منفی برای جابجایی */

            display: flex;
            justify-content: center;
        }

        /* 2. استایل دهی به دایره‌های غیرفعال (پیش‌فرض) */
        .swiper-pagination-bullet {
            /* رنگ و استایل لوکس قبلی */
            background-color: transparent !important;
            border: 2px solid #a1a1aa;
            opacity: 0.7 !important;
            width: 10px;
            height: 10px;
            margin: 0 5px !important;
            transition: all 0.3s ease;
        }

        /* 3. استایل دهی به دایره فعال (طلایی) */
        .swiper-pagination-bullet-active {
            /* رنگ طلایی فعال */
            background-color: #f59e0b !important;
            opacity: 1 !important;
            border: 2px solid #f59e0b !important;
            transform: scale(1.1);
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="font-serif">
    @yield('main')
<footer class="flex flex-col space-y-10 justify-center m-10 bg-white pt-10">

    <nav class="flex justify-center flex-wrap gap-8 text-gray-700 font-medium tracking-widest uppercase text-lg">
        @php $menus = \App\Models\Page::all() @endphp
        @foreach($menus as $menu)
            <a href="{{route('page.show',$menu->slug)}}" class="hover:text-yellow-600 transition duration-200">{{str(ucwords($menu->title))}}</a>
        @endforeach
    </nav>

    <div class="flex justify-center space-x-6">
        @if(setting('social_facebook'))
            <a href="{{setting('social_facebook')}}" target="_blank" rel="noopener noreferrer" class="text-2xl text-gray-700 hover:text-yellow-600 transition duration-200">
                <ion-icon name="logo-facebook"></ion-icon>
            </a>
        @endif
        @if(setting('social_youtube'))
            <a href="{{setting('social_youtube')}}" target="_blank" rel="noopener noreferrer" class="text-2xl text-gray-700 hover:text-yellow-600 transition duration-200">
                <ion-icon name="logo-linkedin"></ion-icon>
            </a>
        @endif
        @if(setting('social_instagram'))
            <a href="{{setting('social_instagram')}}" target="_blank" rel="noopener noreferrer" class="text-2xl text-gray-700 hover:text-yellow-600 transition duration-200">
                <ion-icon name="logo-instagram"></ion-icon>
            </a>
        @endif
        @if(setting('social_twitter'))
            <a href="{{setting('social_twitter')}}" target="_blank" rel="noopener noreferrer" class="text-2xl text-gray-700 hover:text-yellow-600 transition duration-200">
                <ion-icon name="logo-twitter"></ion-icon>
            </a>
        @endif
    </div>
    <p class="text-center text-gray-500 font-light tracking-wider pb-6">&copy; 2025 {{setting('site_title')}}. All rights reserved.</p>
</footer>
<script>
    var swiper = new Swiper(".mySwiper", {
        // تنظیمات اصلی
        slidesPerView: 1, // در حالت موبایل فقط ۱ کارت
        spaceBetween: 24, // فاصله بین کارت‌ها (معادل gap-6)

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        // تنظیمات ریسپانسیو (برای دسکتاپ)
        breakpoints: {
            640: { // sm
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: { // lg
                slidesPerView: 3, // در دسکتاپ ۳ کارت
                spaceBetween: 30,
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
