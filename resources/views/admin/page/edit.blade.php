@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">
        @if ($errors->any())
            <div class="bg-red-50 border-r-4 border-red-500 text-red-700 p-4 rounded-lg mb-8 shadow-lg transition-all duration-300">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-xl ml-3"></i>
                    <p class="font-semibold text-sm">لطفاً خطاهای زیر را برطرف کنید.</p>
                </div>
            </div>
        @endif
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <div class="flex justify-between items-center pb-6 border-b border-gray-100 mb-8">
                <h2 class="text-2xl font-extrabold text-gray-800">
                    <i class="fas fa-edit text-blue-500 ml-2"></i>
                    ویرایش صفحه
                </h2>
                <button form="pageForm" type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6
                                text-sm rounded-xl shadow-lg shadow-blue-500/50 transition duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    ذخیره تغییرات
                </button>
            </div>
            <form id="pageForm" action="{{ route('admin.page.update', $page->id) }}" method="post" enctype="multipart/form-data" class="space-y-8" multiple>
                @csrf @method('PUT')
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 transition duration-300 hover:shadow-xl">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">عنوان <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ $page->title }}"
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-2
                                    focus:ring-blue-100 transition duration-150"
                            >
                            @error('title') <span class="text-red-500">{{$message}}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">اسلاگ (URL)</label>
                            <input type="text" name="slug" value="{{ $page->slug }}" disabled
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 text-sm bg-gray-50 focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-100 transition duration-150" placeholder="مثال: about-us"
                            >
                            @error('slug') <span class="text-red-500">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6 mt-6">
                        <div class="space-y-2">
                            <label class="block text-gray-700 text-sm font-medium mb-2">تصویر</label>
                            <input type="file" name="image"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                   file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                            >
                            @error('image') <span class="text-red-500">{{$message}}</span> @enderror
                        </div>
                        <div class="flex items-center justify-end">
                            <label class="text-gray-700 text-sm font-medium ml-4">تصویر فعلی:</label>
                            <img src="{{ asset($page->image) }}" class="w-28 h-auto object-cover rounded-lg border-2 border-gray-200 shadow-md">
                        </div>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2">توضیحات</label>
                        <textarea name="text" rows="3"
                                  class="w-full px-4 py-2 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-2
                                  focus:ring-blue-100 transition duration-150"
                        >{{ $page->text }}</textarea>
                        @error('text') <span class="text-red-500">{{$message}}</span> @enderror
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
