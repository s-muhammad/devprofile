@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">
        @if(session('success'))
            <div class="bg-green-50 border-r-4 border-green-500 text-green-700 p-4 rounded-xl mb-8 shadow-md transition-all duration-300">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-xl ml-3"></i>
                    <p class="font-semibold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-200">
            <h2 class="text-3xl font-extrabold text-gray-800">
                <i class="fas fa-sliders-h text-indigo-600 ml-3"></i>
                لیست بنرها
            </h2>
            <a href="{{ route('admin.banner.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3
            px-8 rounded-xl shadow-lg shadow-indigo-500/50 transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                <i class="fas fa-plus"></i>
                افزودن بنر جدید
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($banners as $banner)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden group transform transition duration-500 hover:scale-[1.02]
                 border border-gray-100 hover:border-indigo-300">
                    <div class="h-40 w-full overflow-hidden relative">
                        <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover
                        transition duration-500 group-hover:opacity-90">
                        <div class="absolute inset-0 bg-black/10"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="title-font text-xl font-bold text-gray-900 mb-2 uppercase tracking-wider group-hover:text-indigo-600
                        transition duration-300">
                            {{ $banner->title}}
                        </h3>
                        @php
                            $page = \App\Models\Page::where('id',$banner->page_id)->first();
                        @endphp
                        <p class="text-sm text-gray-500 mb-4">{{ $page['title'] }}</p>
                        <div class="flex items-center flex-wrap justify-end space-x-3 space-x-reverse">
                            <a href="{{ route('admin.banner.edit', $banner->id) }}" title="ویرایش" class="text-indigo-600 hover:text-indigo-800
                             p-2 rounded-full hover:bg-indigo-100 transition duration-200">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST"
                                  onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این بنر را حذف کنید؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="حذف" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-100
                                 transition duration-200 focus:outline-none">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-3 bg-white p-10 rounded-2xl shadow-xl text-center border-t-4 border-indigo-400">
                    <i class="fas fa-image mb-3 text-4xl text-gray-300"></i>
                    <p class="text-xl text-gray-600 font-light">هیچ بنری برای نمایش وجود ندارد.</p>
                    <a href="{{ route('admin.banner.create') }}" class="mt-4 inline-block text-indigo-600 font-bold hover:text-indigo-800
                     transition duration-200 items-center justify-center">
                        <i class="fas fa-plus ml-2"></i> اولین بنر را اضافه کنید.
                    </a>
                </div>
            @endforelse
        </div>
    </main>
@endsection
