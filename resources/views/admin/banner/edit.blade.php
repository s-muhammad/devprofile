@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-200">
                <h2 class="text-3xl font-extrabold text-gray-800">
                    <i class="fas fa-edit text-indigo-600 ml-3"></i>
                    ویرایش بنر
                </h2>
                <span class="text-gray-500 text-lg">بنر: {{ $banner->title }}</span>
            </div>
            <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data"
                  class="bg-white rounded-2xl shadow-xl p-8 space-y-8">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="col-span-full border-b pb-6 mb-2 border-gray-200">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">تصویر بنر</label>
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                            @if(isset($banner->image) && $banner->image)
                                <img src="{{ asset($banner->image) }}" class="w-32 h-20 object-cover rounded-lg border-2
                                        border-indigo-400 shadow-md transition duration-200 hover:scale-105" alt="تصویر بنر">
                            @else
                                <div class="w-32 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400
                                        text-xs border border-dashed border-gray-300">
                                    تصویر موجود نیست
                                </div>
                            @endif
                            <input type="file" name="image"
                                   class="w-full text-xs text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                                            file:text-sm file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200
                                            cursor-pointer transition duration-200 mt-2 md:mt-0"
                            >
                            @error("image") <span class="text-red-500 text-xs mt-1">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">عنوان بنر</label>
                        <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100
                                transition duration-300" placeholder="عنوان اصلی بنر">
                        @error("title") <span class="text-red-500 text-xs mt-1">{{$message}}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">لینک (URL)</label>
                        <div class="relative">
                            <i class="fas fa-link absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="link" value="{{ old('link', $banner->link) }}"
                                   class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-xl text-sm focus:border-indigo-600 focus:ring-4
                                   focus:ring-indigo-100 transition duration-300" placeholder="https://...">
                            @error("link") <span class="text-red-500 text-xs mt-1">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">متن دکمه لینک</label>
                        <input type="text" name="label" value="{{ old('label', $banner->label) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100
                               transition duration-300" placeholder="بیشتر بدانید">
                        @error("label") <span class="text-red-500 text-xs mt-1">{{$message}}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">نمایش در</label>
                        <select name="page_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:border-indigo-600 focus:ring-4
                                focus:ring-indigo-100 transition duration-300 bg-white">
                            @foreach($pages as $page)
                            <option value="{{$page->id}}" {{ $page->id == $banner->page_id ? 'selected' : '' }}>{{$page->title}}</option>
                            @endforeach
                        </select>
                        @error("page_id") <span class="text-red-500 text-xs mt-1">{{$message}}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">موقعیت نمایش بنر</label>
                        <select name="position"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:border-indigo-600 focus:ring-4
                                focus:ring-indigo-100 transition duration-300 bg-white">
                            <option value="hero" {{ $banner->position == 'hero' ? 'selected' : '' }}>بنر یک</option>
                            <option value="banner" {{ $banner->position == 'banner' ? 'selected' : '' }}>بنر دو</option>
                        </select>
                        @error("position") <span class="text-red-500 text-xs mt-1">{{$message}}</span> @enderror
                    </div>
                    <div class="col-span-full mt-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">متن توضیحی (شرح کوتاه)</label>
                        <textarea name="text" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:border-indigo-600 focus:ring-4
                                   focus:ring-indigo-100 transition duration-300 resize-none"
                                  placeholder="این متن به عنوان شرح کوتاه یا توضیحات بنر نمایش داده می‌شود.">{{ old('text', $banner->text) }}</textarea>
                        @error("text") <span class="text-red-500 text-xs mt-1">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-500/50
                             transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                        <i class="fas fa-sync-alt"></i>
                        به‌روزرسانی بنر
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
