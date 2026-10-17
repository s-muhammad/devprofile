@php
    $tabs = [
        'admin.seo.keywords.index' => ['label' => 'کلمات کلیدی', 'icon' => 'fas fa-key'],
        'admin.seo.tasks.index' => ['label' => 'کارها', 'icon' => 'fas fa-tasks'],
    ];
@endphp
<div class="border-b border-gray-200 mb-8">
    <nav class="flex space-x-2 space-x-reverse">
        @foreach($tabs as $route => $tab)
            @php $isActive = request()->routeIs($route); @endphp
            <a href="{{ route($route) }}"
               class="px-5 py-3 font-semibold text-sm rounded-t-lg transition-colors duration-200 flex items-center gap-2
                      {{ $isActive ? 'text-white bg-blue-600 shadow-lg' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }}">
                <i class="{{ $tab['icon'] }}"></i>
                {{ $tab['label'] }}
            </a>
        @endforeach
    </nav>
</div>
