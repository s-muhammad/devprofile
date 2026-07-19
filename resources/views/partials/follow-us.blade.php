<section class="max-w-[1320px] mx-auto px-6 lg:px-14 py-10">
    <div class="rounded-3xl border border-[var(--border)] bg-[var(--bg-soft)] px-6 md:px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-7">

        <div class="text-center md:text-right">
            <h3 class="font-extrabold text-lg mb-1.5">ما را دنبال کنید</h3>
            <p class="text-sm text-[var(--muted)] leading-6">آخرین مقالات و پروژه‌ها رو توی شبکه‌های اجتماعی هم منتشر می‌کنم.</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">

            @if (setting('social_instagram'))
                <a href="{{ setting('social_instagram') }}" target="_blank" rel="noopener" title="اینستاگرام"
                   class="w-12 h-12 rounded-full bg-white border border-[var(--border)] flex items-center justify-center text-[#E1306C]
                          hover:-translate-y-1 hover:shadow-lg hover:border-transparent transition-all duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </a>
            @endif

            @if (setting('social_youtube'))
                <a href="{{ setting('social_youtube') }}" target="_blank" rel="noopener" title="یوتیوب"
                   class="w-12 h-12 rounded-full bg-white border border-[var(--border)] flex items-center justify-center text-[#FF0000]
                          hover:-translate-y-1 hover:shadow-lg hover:border-transparent transition-all duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
            @endif

        </div>

    </div>
</section>
