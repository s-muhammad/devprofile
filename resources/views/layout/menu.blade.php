<header x-data="{ open: false }" class="relative z-20 flex flex-wrap items-center py-4 px-4 lg:px-16 border-b border-white/10">
    <div class="flex-1 flex items-center justify-between">
        <a href="{{route('page.show',$page->slug)}}" class="text-3xl font-extrabold text-white tracking-widest uppercase">
            {{setting('site_title')}}<span class="text-yellow-500">.</span>
        </a>
        <button @click="open = !open" class="md:hidden text-white focus:outline-none">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="hidden md:flex space-x-8 text-white font-medium tracking-widest">
        @php $menus = \App\Models\Page::all() @endphp
        @foreach($menus as $menu)
            <a href="{{route('page.show',$menu->slug)}}" class="hover:text-yellow-500 transition duration-200">{{str(ucwords($menu->title))}}</a>
        @endforeach
    </nav>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        @click.away="open = false"
        class="absolute top-full left-0 w-full bg-black/80 md:hidden z-40 shadow-lg"
    >
        <ul class="flex flex-col text-white font-medium tracking-widest">
            @php $menus = \App\Models\Page::all() @endphp
            @foreach($menus as $menu)
                <li>
                    <a class="py-4 px-6 block border-b border-gray-700 hover:bg-white/10" href="{{route('page.show',$menu->slug)}}">
                        {{str(ucwords($menu->title))}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</header>
