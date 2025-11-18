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
                لیست سرویس‌ها (خدمات)
            </h2>
            {{-- دکمه ایجاد سرویس جدید با طراحی برجسته و رنگ تم جدید --}}
            <a href="{{ route('admin.service.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-500/50 transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                <i class="fas fa-plus"></i>
                ایجاد سرویس جدید
            </a>
        </div>

        {{-- کانتینر جدول با سایه و گوشه‌های گردتر --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 overflow-x-auto">
            <table class="min-w-full text-right divide-y divide-gray-200">
                <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase font-semibold tracking-wider">
                    <th class="py-4 px-4 rounded-r-xl">#</th>
                    <th class="py-4 px-4">عنوان سرویس</th>
                    <th class="py-4 px-4">متن کوتاه</th>
                    <th class="py-4 px-4 text-center">تصویر/آیکون</th>
                    <th class="py-4 px-4 rounded-l-xl text-center">عملیات</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($services as $service)
                    {{-- استفاده از رنگ تم در هاور --}}
                    <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                        <td class="py-4 px-4 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="py-4 px-4 font-semibold text-gray-800">{{ $service->title }}</td>
                        {{-- محدود کردن متن کوتاه --}}
                        <td class="py-4 px-4 text-gray-600 max-w-sm text-sm">{{ Str::limit($service->summary, 60) }}</td>

                        {{-- نمایش تصویر/آیکون --}}
                        <td class="py-4 px-4 text-center">
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" class="w-16 h-10 object-cover rounded-md shadow-sm mx-auto">
                            @else
                                <i class="fas fa-cube text-xl text-gray-400"></i>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <a href="{{ route('admin.service.edit', $service) }}" title="ویرایش" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition duration-200">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('admin.service.destroy', $service) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید سرویس {{ $service->title }} را حذف کنید؟');">
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
                            <p>هیچ سرویسی برای نمایش وجود ندارد.</p>
                            <p class="text-sm mt-1">از دکمه بالا برای اضافه کردن اولین سرویس استفاده کنید.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- صفحه‌بندی --}}
        @if(method_exists($services, 'links'))
            <div class="mt-8 flex justify-center">
                {{ $services->links() }}
            </div>
        @endif

    </main>
@endsection
