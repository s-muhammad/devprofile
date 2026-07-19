@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">👋 اقدامات سریع </h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <a href="{{ route('admin.blog.create') }}" class="block transform transition-transform duration-300 hover:scale-[1.03]">
                <div class="bg-white rounded-xl shadow-xl p-6 md:p-8 border-r-4 border-purple-500 hover:bg-purple-50">
                    <div class="flex items-center justify-between">
                        <i class="fas fa-plus-square text-4xl text-purple-600"></i>
                        <span class="text-xs font-semibold uppercase text-purple-600">جدید</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mt-4">مقاله جدید</h3>
                    <p class="text-sm text-gray-500 mt-1">ایجاد محتوای آموزشی و بلاگی جدید.</p>
                </div>
            </a>
            <a href="{{ route('admin.projects.create') }}" class="block transform transition-transform duration-300 hover:scale-[1.03]">
                <div class="bg-white rounded-xl shadow-xl p-6 md:p-8 border-r-4 border-blue-500 hover:bg-blue-50">
                    <div class="flex items-center justify-between">
                        <i class="fas fa-concierge-bell text-4xl text-blue-600"></i>
                        <span class="text-xs font-semibold uppercase text-blue-600">مدیریت</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mt-4">پروژه جدید</h3>
                    <p class="text-sm text-gray-500 mt-1">ایجاد پروژه جدید.</p>
                </div>
            </a>
        </div>
{{--        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2 mt-8">🔍 فعالیت‌های اخیر</h1>--}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-book-open text-purple-600 text-xl ml-3"></i>
                        <span>آخرین مقالات منتشر شده</span>
                    </div>
                    <a href="{{ route('admin.blog.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-800 transition-colors">مشاهده همه &larr;</a>
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-right whitespace-nowrap">
                        <thead>
                        <tr class="text-gray-600 border-b-2 border-gray-200 text-sm uppercase tracking-wider bg-gray-50">
                            <th class="py-3 px-4 w-10">#</th>
                            <th class="py-3 px-4">عنوان مقاله</th>
                            <th class="py-3 px-4">تصویر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($blogs as $blog)
                            <tr class="border-b border-gray-100 hover:bg-purple-50/50 transition-colors duration-200">
                                <td class="py-3 px-4 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 font-medium text-gray-900 max-w-xs truncate">{{ $blog->title }}</td>
                                <td class="py-3 px-4">
                                    @if(isset($blog->image) && $blog->image)
                                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-12 h-10 object-cover rounded-md shadow">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">مقاله جدیدی برای نمایش وجود ندارد.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-hands-helping text-red-600 text-xl ml-3"></i>
                        <span>آخرین پروژه ها</span>
                    </div>
                    <a href="{{ route('admin.projects.index') }}" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors">مشاهده همه &larr;</a>
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-right whitespace-nowrap">
                        <thead>
                        <tr class="text-gray-600 border-b-2 border-gray-200 text-sm uppercase tracking-wider bg-gray-50">
                            <th class="py-3 px-4 w-10">#</th>
                            <th class="py-3 px-4">عنوان </th>
                            <th class="py-3 px-4">تصویر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($projects as $project)
                            <tr class="border-b border-gray-100 hover:bg-red-50/50 transition-colors duration-200">
                                <td class="py-3 px-4 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 font-medium text-gray-900">{{ $project->title ?? 'کاربر ناشناس' }}</td>
                                <td class="py-3 px-4">
                                    @if(isset($project->image) && $project->image)
                                        <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="w-12 h-10 object-cover rounded-md shadow">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">پروژه جدیدی برای نمایش وجود ندارد.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>
@endsection
