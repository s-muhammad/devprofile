@php $task = $task ?? null; @endphp
<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                <span class="font-bold">خطا:</span>
            </div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label for="title" class="block text-gray-700 text-sm font-semibold mb-2">عنوان <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title ?? '') }}"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="مثلاً بهینه‌سازی سرعت صفحه اصلی" required>
        </div>

        <div class="md:col-span-2">
            <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">توضیحات</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="توضیح مختصر کار">{{ old('description', $task->description ?? '') }}</textarea>
        </div>

        <div>
            <label for="priority" class="block text-gray-700 text-sm font-semibold mb-2">اولویت <span class="text-red-500">*</span></label>
            <select id="priority" name="priority"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(\App\Models\SeoTask::PRIORITIES as $value => $label)
                    <option value="{{ $value }}" @selected(old('priority', $task->priority ?? 'medium') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status" class="block text-gray-700 text-sm font-semibold mb-2">وضعیت <span class="text-red-500">*</span></label>
            <select id="status" name="status"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(\App\Models\SeoTask::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $task->status ?? 'todo') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="due_date" class="block text-gray-700 text-sm font-semibold mb-2">تاریخ سررسید (شمسی)</label>
            <input type="text" id="due_date" name="due_date"
                   value="{{ old('due_date', $task && $task->due_date ? jalali_date($task->due_date) : '') }}"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="۱۴۰۵/۰۷/۲۶" dir="ltr">
        </div>

        <div>
            <label for="seo_keyword_id" class="block text-gray-700 text-sm font-semibold mb-2">کلمه کلیدی مرتبط</label>
            <select id="seo_keyword_id" name="seo_keyword_id"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">بدون کلمه کلیدی</option>
                @foreach($keywords as $keyword)
                    <option value="{{ $keyword->id }}" @selected(old('seo_keyword_id', $task->seo_keyword_id ?? '') == $keyword->id)>{{ $keyword->keyword }}</option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="related_url" class="block text-gray-700 text-sm font-semibold mb-2">آدرس مرتبط</label>
            <input type="text" id="related_url" name="related_url" value="{{ old('related_url', $task->related_url ?? '') }}" dir="ltr"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 text-left focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="مثلاً /blog/web-design">
        </div>
    </div>

    <div class="flex justify-between mt-8 space-x-4 space-x-reverse">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition">
            <i class="fas fa-save ml-2"></i> ذخیره
        </button>
        <a href="{{ route('admin.seo.tasks.index') }}"
           class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-3 px-8 rounded-full transition">
            <i class="fas fa-arrow-right ml-2"></i> انصراف
        </a>
    </div>
</form>
