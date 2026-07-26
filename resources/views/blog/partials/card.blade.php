@foreach($blogs as $blog)
    <article class="blog-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-[var(--border)] hover:-translate-y-1"
             style="opacity:0; transform:translateY(20px);">
        <a href="{{ url('blog',$blog->id) }}">
            <div class="relative overflow-hidden">
                <img src="{{ asset($blog->image) }}" class="w-full h-48 object-cover transition-transform duration-500 hover:scale-105" alt="{{ $blog->title }}">
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-3 text-xs text-[var(--muted)]">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $blog->reading_time }} دقیقه مطالعه
                    </span>
                    <span class="bg-[var(--accent-soft)] text-[var(--accent)] px-2.5 py-1 rounded-lg font-medium">مقاله</span>
                </div>
                <h3 class="text-lg font-bold mb-2 text-[var(--ink)] leading-relaxed line-clamp-2">{{ $blog->title }}</h3>
                <p class="text-[var(--muted)] text-sm leading-relaxed line-clamp-2">{{ $blog->summary }}</p>
            </div>
        </a>
    </article>
@endforeach
