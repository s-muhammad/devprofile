@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">

        {{-- اعلان موفقیت (با طراحی بهتر) --}}
        @if(session('success'))
            <div class="bg-green-50 border-r-4 border-green-500 text-green-700 p-4 rounded-lg mb-8 shadow-md transition-all duration-300">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-xl ml-3"></i>
                    <p class="font-semibold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- عنوان و دکمه ایجاد --}}
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200">
            <h2 class="text-3xl font-extrabold text-gray-800">
                <i class="fas fa-handshake text-indigo-600 ml-3"></i>
                لیست پروژه ها
            </h2>
            {{-- دکمه ایجاد سرویس جدید با طراحی برجسته و رنگ تم جدید --}}
            <a href="{{ route('admin.projects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-500/50 transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                <i class="fas fa-plus"></i>
                ایجاد پروژه جدید
            </a>
        </div>

        {{-- کانتینر جدول با سایه و گوشه‌های گردتر --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 overflow-x-auto">
            <table class="min-w-full text-right divide-y divide-gray-200">
                <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase font-semibold tracking-wider">
                    <th class="py-4 px-4 rounded-r-xl">#</th>
                    <th class="py-4 px-4">عنوان </th>
                    <th class="py-4 px-4">متن </th>
                    <th class="py-4 px-4">ویژه</th>
                    <th class="py-4 px-4 text-center">تصویر</th>
                    <th class="py-4 px-4 rounded-l-xl text-center">عملیات</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($projects as $project)
                    {{-- استفاده از رنگ تم در هاور --}}
                    <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                        <td class="py-4 px-4 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="py-4 px-4 font-semibold text-gray-800">{{ $project->title }}</td>
                        {{-- محدود کردن متن کوتاه --}}
                        <td class="py-4 px-4 text-gray-600 max-w-sm text-sm">{{ Str::limit($project->description, 60) }}</td>
                        <td class="py-4 px-4 text-center">
                            @if($project->is_featured)
                                <i class="fas fa-check"></i>
                            @else
                                <i class="fas fa-times"></i>
                            @endif
                        </td>
                        {{-- نمایش تصویر/آیکون --}}
                        <td class="py-4 px-4 text-center">
                            @if($project->image)
                                <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="w-16 h-10 object-cover rounded-md shadow-sm mx-auto">
                            @else
                                <i class="fas fa-cube text-xl text-gray-400"></i>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <a href="{{ route('admin.projects.edit', $project) }}" title="ویرایش" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition duration-200">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید سرویس {{ $project->title }} را حذف کنید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="حذف" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-100 transition duration-200 focus:outline-none">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500 text-lg">
                            <i class="fas fa-tools mb-3 text-3xl text-gray-300"></i>
                            <p>هیچ پروژه ای برای نمایش وجود ندارد.</p>
                            <p class="text-sm mt-1">از دکمه بالا برای اضافه کردن اولین پروژه استفاده کنید.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- صفحه‌بندی --}}
        @if(method_exists($projects, 'links'))
            <div class="mt-8 flex justify-center">
                {{ $projects->links() }}
            </div>
        @endif

    </main>
@endsection
