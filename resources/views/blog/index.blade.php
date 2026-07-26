@extends('partials.layout')
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
                    <img src="{{ $header->image }}"
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                         alt="Featured">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-8 text-white">
                        <span class="bg-indigo-500 w-fit px-3 py-1 rounded-lg text-sm mb-4">ویژه امروز</span>
                        <h2 class="text-3xl font-bold mb-2 leading-snug">{{ $header->title }}</h2>
                        <p class="text-slate-300 max-w-xl">{{ $header->summary }}</p>
                    </div>
                </div>
            </a>
        </section>

        <div id="blogGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @include('blog.partials.card', ['blogs' => $blogs])
        </div>

        @if($blogs->hasMorePages())
            <div class="flex flex-col items-center gap-4 py-8" id="loadMoreWrapper">
                <button id="loadMoreBtn"
                        data-page="2"
                        data-url="{{ route('blog.loadMore') }}"
                        class="group relative inline-flex items-center gap-3 px-8 py-3.5 rounded-full bg-[var(--ink)] text-white font-bold text-sm overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-[var(--ink)]/20 hover:scale-[1.02] active:scale-[0.98]">
                    <span class="relative z-10 flex items-center gap-2">
                        <span id="loadMoreText">مقالات بیشتر</span>
                        <svg id="loadMoreIcon" class="w-4 h-4 transition-transform duration-300 group-hover:translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                    <span id="loadMoreSpinner" class="hidden relative z-10">
                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </span>
                    <span class="absolute inset-0 bg-gradient-to-l from-[var(--accent)] to-[var(--ink)] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </button>

                <p class="text-xs text-[var(--muted-2)]">
                    <span id="blogCount">{{ $blogs->count() }}</span> از {{ $total }} مقاله
                </p>
            </div>
        @endif

    </main>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .blog-card {
            animation: fadeUp 0.4s ease forwards;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, var(--bg-soft) 25%, #e8e8f0 50%, var(--bg-soft) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 12px;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('loadMoreBtn');
        if (!btn) return;

        const grid = document.getElementById('blogGrid');
        const text = document.getElementById('loadMoreText');
        const icon = document.getElementById('loadMoreIcon');
        const spinner = document.getElementById('loadMoreSpinner');
        const countEl = document.getElementById('blogCount');
        const wrapper = document.getElementById('loadMoreWrapper');
        let page = parseInt(btn.dataset.page);
        const url = btn.dataset.url;

        btn.addEventListener('click', function() {
            btn.disabled = true;
            text.textContent = 'در حال بارگذاری...';
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');

            fetch(`${url}?page=${page}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                const temp = document.createElement('div');
                temp.innerHTML = data.html;
                const cards = temp.querySelectorAll('.blog-card');

                cards.forEach((card, i) => {
                    card.style.animationDelay = `${i * 0.08}s`;
                    grid.appendChild(card);
                });

                page++;
                countEl.textContent = grid.querySelectorAll('.blog-card').length;

                if (data.hasMore) {
                    btn.dataset.page = page;
                    btn.disabled = false;
                    text.textContent = 'مقالات بیشتر';
                    icon.classList.remove('hidden');
                    spinner.classList.add('hidden');
                } else {
                    wrapper.innerHTML = '<p class="text-sm text-[var(--muted)] py-4">تمام مقالات نمایش داده شد</p>';
                }
            })
            .catch(() => {
                btn.disabled = false;
                text.textContent = 'مقالات بیشتر';
                icon.classList.remove('hidden');
                spinner.classList.add('hidden');
            });
        });
    });
    </script>
@endsection
