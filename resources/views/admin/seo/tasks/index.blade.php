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
            <a href="{{ route('admin.seo.tasks.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg
                      shadow-blue-500/50 transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                <i class="fas fa-plus"></i>
                افزودن کار
            </a>
        </div>

        @include('admin.seo.partials.tabs')

        <form method="GET" action="{{ route('admin.seo.tasks.index') }}"
              class="bg-white rounded-2xl shadow-md p-4 mb-6 flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[220px]">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجوی عنوان کار..."
                       class="w-full pr-10 pl-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select name="status"
                    class="px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">همه وضعیت‌ها</option>
                @foreach(\App\Models\SeoTask::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="priority"
                    class="px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">همه اولویت‌ها</option>
                @foreach(\App\Models\SeoTask::PRIORITIES as $value => $label)
                    <option value="{{ $value }}" @selected(request('priority') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2.5 px-6 rounded-lg transition">
                <i class="fas fa-filter ml-1"></i> فیلتر
            </button>
            @if(request()->filled('search') || request()->filled('status') || request()->filled('priority'))
                <a href="{{ route('admin.seo.tasks.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">
                    حذف فیلترها
                </a>
            @endif
        </form>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 overflow-x-auto">
            <table class="min-w-full text-right divide-y divide-gray-200">
                <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase font-semibold tracking-wider">
                    <th class="py-4 px-4 rounded-r-xl">#</th>
                    <th class="py-4 px-4">عنوان</th>
                    <th class="py-4 px-4">کلمه کلیدی</th>
                    <th class="py-4 px-4 text-center">اولویت</th>
                    <th class="py-4 px-4 text-center">وضعیت</th>
                    <th class="py-4 px-4 text-center">سررسید</th>
                    <th class="py-4 px-4 rounded-l-xl text-center">عملیات</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($tasks as $task)
                    @php
                        $isOverdue = $task->isOverdue();
                        $isDone = $task->isDone();
                    @endphp
                    <tr class="{{ $isDone ? 'opacity-50 bg-gray-50' : ($isOverdue ? 'bg-red-50' : 'hover:bg-blue-50/50') }} transition-colors duration-200">
                        <td class="py-4 px-4 text-gray-500">{{ $tasks->firstItem() + $loop->index }}</td>
                        <td class="py-4 px-4 max-w-xs">
                            <span class="font-semibold text-gray-800 block truncate {{ $isDone ? 'line-through' : '' }}">{{ $task->title }}</span>
                            @if($task->related_url)
                                <span class="block text-xs text-gray-400 truncate dir-ltr text-left">{{ $task->related_url }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-gray-600 text-sm">{{ $task->keyword->keyword ?? '-' }}</td>
                        <td class="py-4 px-4 text-center">
                            @php
                                $priorityColors = ['low' => 'bg-gray-100 text-gray-700', 'medium' => 'bg-blue-100 text-blue-700', 'high' => 'bg-red-100 text-red-700'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $priorityColors[$task->priority] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $task->priorityLabel() }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center text-sm">
                            @if($isDone)
                                <span class="text-green-600 font-semibold"><i class="fas fa-check-circle ml-1"></i> {{ $task->statusLabel() }}</span>
                            @else
                                <span class="text-gray-700">{{ $task->statusLabel() }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center text-sm">
                            @if($task->due_date)
                                <span class="{{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                    @if($isOverdue)<i class="fas fa-exclamation-triangle ml-1"></i>@endif
                                    {{ jalali_date($task->due_date) }}
                                </span>
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <form action="{{ route('admin.seo.tasks.toggle', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="{{ $isDone ? 'بازگردانی به انجام‌نشده' : 'علامت‌گذاری به عنوان انجام‌شده' }}"
                                            class="{{ $isDone ? 'text-amber-500 hover:text-amber-700' : 'text-green-600 hover:text-green-800' }} p-2 rounded-full hover:bg-green-100 transition duration-200">
                                        <i class="fas {{ $isDone ? 'fa-undo' : 'fa-check' }} text-lg"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.seo.tasks.edit', $task) }}" title="ویرایش"
                                   class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition duration-200">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('admin.seo.tasks.destroy', $task) }}" method="POST"
                                      onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این کار را حذف کنید؟');">
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
                        <td colspan="7" class="py-12 text-center text-gray-500 text-lg">
                            <i class="fas fa-tasks mb-3 text-3xl text-gray-300"></i>
                            <p>هیچ کاری برای نمایش وجود ندارد.</p>
                            <p class="text-sm mt-1">از دکمه بالا برای افزودن اولین کار استفاده کنید.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8 flex justify-center">
            {{ $tasks->links() }}
        </div>
    </main>
@endsection
