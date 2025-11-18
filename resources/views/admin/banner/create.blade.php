@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-200">
                <h2 class="text-3xl font-extrabold text-gray-800">
                    <i class="fas fa-plus-square text-indigo-600 ml-3"></i>
                    افزودن بنر جدید
                </h2>
            </div>
            <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white rounded-2xl shadow-xl p-8 space-y-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">تصویر بنر</h3>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            انتخاب فایل تصویری (JPG, PNG)
                        </label>
                        <input type="file" name="image" id="image" required
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-gray-50
                                focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 p-3 transition duration-300">
                        @error('image')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">جزئیات محتوا</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">عنوان </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="mt-1 block w-full border-b border-gray-300 py-3 px-1 focus:border-indigo-600 focus:ring-0
                                       sm:text-base transition duration-200 bg-transparent rounded-sm"
                                       placeholder="عنوان اصلی بنر">
                                @error('title')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="link" class="block text-sm font-semibold text-gray-700 mb-1">لینک مقصد (URL)</label>
                                <input type="text" name="link" id="link" value="{{ old('link') }}" placeholder="مثال: /services"
                                       class="mt-1 block w-full border-b border-gray-300 py-3 px-1 focus:border-indigo-600 focus:ring-0
                                        sm:text-base transition duration-200 bg-transparent rounded-sm">
                                @error('link')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="label" class="block text-sm font-semibold text-gray-700 mb-1">متن دکمه لینک</label>
                                <input type="text" name="label" id="label" value="{{ old('label') }}"
                                       class="mt-1 block w-full border-b border-gray-300 py-3 px-1 focus:border-indigo-600 focus:ring-0
                                        sm:text-base transition duration-200 bg-transparent rounded-sm"
                                       placeholder="بیشتر بدانید">
                                @error('label')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-span-full">
                            <label for="text" class="block text-sm font-semibold text-gray-700 mb-1">متن توضیحی (شرح کوتاه)</label>
                            <textarea name="text" id="text" rows="3"
                                      class="mt-1 block w-full border border-gray-300 rounded-xl py-2.5 px-3 focus:border-indigo-600 focus:ring-4
                                       focus:ring-indigo-100
                                       sm:text-base transition duration-200 resize-none"
                                      placeholder="متن کوچک زیر عنوان یا توضیحات بنر">{{ old('text') }}</textarea>
                            @error('text')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4 pt-4 pb-2 border-t border-b border-gray-100">تنظیمات نمایش</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="page_id" class="block text-sm font-semibold text-gray-700 mb-1"> نمایش در</label>
                                <select name="page_id" id="page_id" required
                                        class="mt-1 block w-full border border-gray-300 py-3 px-3 focus:border-indigo-600 focus:ring-indigo-500
                                         sm:text-base rounded-xl transition duration-200 bg-white">
                                    @php
                                        $pages = \App\Models\Page::all();
                                    @endphp
                                    @foreach($pages as $page)
                                        <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                                    @endforeach
                                </select>
                                @error('page_id')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="position" class="block text-sm font-semibold text-gray-700 mb-1">موقعیت نمایش بنر</label>
                                <select name="position" id="position" required
                                        class="mt-1 block w-full border border-gray-300 py-3 px-3 focus:border-indigo-600 focus:ring-indigo-500 sm:text-base
                                         rounded-xl transition duration-200 bg-white">
                                    <option value="home_slider" {{ old('position') == 'home_slider' ? 'selected' : '' }}>اسلایدر صفحه اصلی</option>
                                    <option value="sidebar_right" {{ old('position') == 'sidebar_right' ? 'selected' : '' }}>نوار کناری راست</option>
                                    <option value="service_page_top" {{ old('position') == 'service_page_top' ? 'selected' : '' }}>بالای صفحه خدمات</option>
                                </select>
                                @error('position')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end border-t border-gray-100">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-500/50
                                transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            ذخیره
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
