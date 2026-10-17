@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">
        @if(session('success'))
            <div class="bg-green-50 border-r-4 border-green-500 text-green-700 p-4 rounded-lg mb-8 shadow-md">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-xl ml-3"></i>
                    <p class="font-semibold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-3xl font-extrabold text-gray-800">
                <i class="fas fa-search text-blue-600 ml-3"></i>
                دفترچه سئو
            </h2>
            <a href="{{ route('admin.seo.keywords.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg
                      shadow-blue-500/50 transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                <i class="fas fa-plus"></i>
                افزودن کلمه کلیدی
            </a>
        </div>

        @include('admin.seo.partials.tabs')

        <form method="GET" action="{{ route('admin.seo.keywords.index') }}"
              class="bg-white rounded-2xl shadow-md p-4 mb-6 flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[220px]">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجوی کلمه کلیدی..."
                       class="w-full pr-10 pl-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select name="status"
                    class="px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">همه وضعیت‌ها</option>
                @foreach(\App\Models\SeoKeyword::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2.5 px-6 rounded-lg transition">
                <i class="fas fa-filter ml-1"></i> فیلتر
            </button>
            @if(request()->filled('search') || request()->filled('status'))
                <a href="{{ route('admin.seo.keywords.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">
                    حذف فیلترها
                </a>
            @endif
        </form>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 overflow-x-auto">
            <table class="min-w-full text-right divide-y divide-gray-200">
                <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase font-semibold tracking-wider">
                    <th class="py-4 px-4 rounded-r-xl">#</th>
                    <th class="py-4 px-4">کلمه کلیدی</th>
                    <th class="py-4 px-4 text-center">حجم جستجو</th>
                    <th class="py-4 px-4 text-center">سختی</th>
                    <th class="py-4 px-4 text-center">قصد</th>
                    <th class="py-4 px-4 text-center">وضعیت</th>
                    <th class="py-4 px-4 text-center">رتبه</th>
                    <th class="py-4 px-4 text-center">کارهای باز</th>
                    <th class="py-4 px-4 rounded-l-xl text-center">عملیات</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($keywords as $keyword)
                    <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                        <td class="py-4 px-4 text-gray-500">{{ $keywords->firstItem() + $loop->index }}</td>
                        <td class="py-4 px-4 font-semibold text-gray-800 max-w-xs">
                            <span class="truncate block">{{ $keyword->keyword }}</span>
                            @if($keyword->target_url)
                                <span class="block text-xs text-gray-400 truncate dir-ltr text-left">{{ $keyword->target_url }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center text-gray-600">{{ $keyword->search_volume ?? '-' }}</td>
                        <td class="py-4 px-4 text-center text-gray-600">
                            {{ $keyword->difficulty ? (\App\Models\SeoKeyword::DIFFICULTIES[$keyword->difficulty] ?? $keyword->difficulty) : '-' }}
                        </td>
                        <td class="py-4 px-4 text-center text-gray-600">
                            {{ $keyword->intent ? (\App\Models\SeoKeyword::INTENTS[$keyword->intent] ?? $keyword->intent) : '-' }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            <form action="{{ route('admin.seo.keywords.status', $keyword) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="px-2 py-1 rounded-lg border border-gray-300 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @foreach(\App\Models\SeoKeyword::STATUSES as $value => $label)
                                        <option value="{{ $value }}" @selected($keyword->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-4 text-center text-gray-600">{{ $keyword->current_rank ?? '-' }}</td>
                        <td class="py-4 px-4 text-center">
                            @if($keyword->open_tasks_count > 0)
                                <span class="inline-flex items-center justify-center min-w-[1.75rem] px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                    {{ $keyword->open_tasks_count }}
                                </span>
                            @else
                                <span class="text-gray-300 text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <a href="{{ route('admin.seo.keywords.edit', $keyword) }}" title="ویرایش"
                                   class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition duration-200">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('admin.seo.keywords.destroy', $keyword) }}" method="POST"
                                      onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این کلمه کلیدی را حذف کنید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="حذف"
                                            class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-100 transition duration-200">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center text-gray-500 text-lg">
                            <i class="fas fa-key mb-3 text-3xl text-gray-300"></i>
                            <p>هیچ کلمه کلیدی برای نمایش وجود ندارد.</p>
                            <p class="text-sm mt-1">از دکمه بالا برای افزودن اولین کلمه کلیدی استفاده کنید.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8 flex justify-center">
            {{ $keywords->links() }}
        </div>
    </main>
@endsection
