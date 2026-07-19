@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
        <div class="w-full max-w-2xl mx-auto">
            <div class="flex items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 ml-4">ایجاد پروژه جدید</h2>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle ml-2"></i>
                                <span class="font-bold">خطا:</span>
                            </div>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- فیلد عنوان --}}
                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 text-sm font-semibold mb-2">عنوان</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                               placeholder="عنوان سرویس را وارد کنید" required>
                    </div>

                    {{-- فیلد آدرس --}}
                    <div class="mb-6">
                        <label for="url" class="block text-gray-700 text-sm font-semibold mb-2">آدرس</label>
                        <input type="text" id="url" name="url" value="{{ old('url') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                               placeholder="آدرس پروژه را وارد کنید">
                    </div>

                    {{-- فیلد توضیحات --}}
                    <div class="mb-6">
                        <label for="content" class="block text-gray-700 text-sm font-semibold mb-2">توضیحات</label>
                        <textarea id="content" name="description" rows="10"
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                                  placeholder="محتوای اصلی سرویس را وارد کنید" required>{{ old('description') }}</textarea>
                    </div>

                    {{-- فیلد تصویر --}}
                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 text-sm font-semibold mb-2">تصویر</label>
                        <div class="flex items-center">
                            <label class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition-colors duration-200">
                                <span>انتخاب فایل</span>
                                <input type="file" id="image" name="image" class="hidden">
                            </label>
                        </div>
                    </div>

                    {{-- فیلد رادیویی پست ویژه --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">پست ویژه</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_featured" value="1" {{ old('is_featured') == '1' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="mr-2 text-gray-700">بله</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_featured" value="0" {{ old('is_featured') == '0' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="mr-2 text-gray-700">خیر</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">در صورت انتخاب «بله»، این پروژه به عنوان پست ویژه نمایش داده می‌شود.</p>
                    </div>

                    <div class="flex justify-between space-x-4 space-x-reverse">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-colors duration-200">
                            <i class="fas fa-save ml-2"></i> ذخیره
                        </button>
                        <a href="{{ route('admin.projects.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-3 px-8 rounded-full transition-colors duration-200">
                            <i class="fas fa-arrow-right ml-2"></i> انصراف
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection
