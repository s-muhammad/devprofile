@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900"> ایجاد صفحه جدید</h2>
        </div>
            <div class="bg-white rounded-lg shadow-md p-5 md:p-6">
                <form action="{{route('admin.page.store')}}" method="post" class="space-y-8" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <i class="fas fa-file-alt text-blue-500"></i>اطلاعات صفحه
                        </h2>
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label for="title" class="block text-gray-700 text-sm font-medium mb-1">عنوان</label>
                                <input type="text" id="title" name="title"
                                       class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                       placeholder="عنوان صفحه را وارد کنید">
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="slug" class="block text-gray-700 text-sm font-medium mb-1">اسلاگ (Slug)</label>
                                <input type="text" id="slug" name="slug"
                                       class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                       placeholder="مثلاً: about-us">
                                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="text" class="block text-gray-700 text-sm font-medium mb-1">توضیحات</label>
                                <input type="text" id="text" name="text"
                                       class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                       placeholder="توضیحات صفحه را وارد کنید">
                                @error('text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="image" class="block text-gray-700 text-sm font-medium mb-1">تصویر</label>
                                <input type="file" id="image" name="image"
                                       class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-6
                                        text-sm rounded-lg shadow-md transition duration-200 flex items-center gap-1">
                            <i class="fas fa-save"></i>                            ذخیره صفحه
                        </button>
                    </div>
                </form>
            </div>
    </main>
@endsection
