@php $keyword = $keyword ?? null; @endphp
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
            <label for="keyword" class="block text-gray-700 text-sm font-semibold mb-2">کلمه کلیدی <span class="text-red-500">*</span></label>
            <input type="text" id="keyword" name="keyword" value="{{ old('keyword', $keyword->keyword ?? '') }}"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="مثلاً طراحی سایت" required>
        </div>

        <div>
            <label for="search_volume" class="block text-gray-700 text-sm font-semibold mb-2">حجم جستجو</label>
            <input type="number" min="0" id="search_volume" name="search_volume" value="{{ old('search_volume', $keyword->search_volume ?? '') }}"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="وارد کردن دستی">
        </div>

        <div>
            <label for="current_rank" class="block text-gray-700 text-sm font-semibold mb-2">رتبه فعلی</label>
            <input type="number" min="0" id="current_rank" name="current_rank" value="{{ old('current_rank', $keyword->current_rank ?? '') }}"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="مثلاً 5">
        </div>

        <div>
            <label for="difficulty" class="block text-gray-700 text-sm font-semibold mb-2">سختی</label>
            <select id="difficulty" name="difficulty"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">انتخاب کنید</option>
                @foreach(\App\Models\SeoKeyword::DIFFICULTIES as $value => $label)
                    <option value="{{ $value }}" @selected(old('difficulty', $keyword->difficulty ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="intent" class="block text-gray-700 text-sm font-semibold mb-2">قصد کاربر</label>
            <select id="intent" name="intent"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">انتخاب کنید</option>
                @foreach(\App\Models\SeoKeyword::INTENTS as $value => $label)
                    <option value="{{ $value }}" @selected(old('intent', $keyword->intent ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status" class="block text-gray-700 text-sm font-semibold mb-2">وضعیت <span class="text-red-500">*</span></label>
            <select id="status" name="status"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(\App\Models\SeoKeyword::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $keyword->status ?? 'idea') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="target_url" class="block text-gray-700 text-sm font-semibold mb-2">آدرس هدف</label>
            <input type="text" id="target_url" name="target_url" value="{{ old('target_url', $keyword->target_url ?? '') }}" dir="ltr"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 text-left focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="مثلاً /blog/web-design">
        </div>

        <div class="md:col-span-2">
            <label for="notes" class="block text-gray-700 text-sm font-semibold mb-2">یادداشت</label>
            <textarea id="notes" name="notes" rows="4"
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="یادداشت‌های خود را وارد کنید">{{ old('notes', $keyword->notes ?? '') }}</textarea>
        </div>
    </div>

    <div class="flex justify-between mt-8 space-x-4 space-x-reverse">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition">
            <i class="fas fa-save ml-2"></i> ذخیره
        </button>
        <a href="{{ route('admin.seo.keywords.index') }}"
           class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-3 px-8 rounded-full transition">
            <i class="fas fa-arrow-right ml-2"></i> انصراف
        </a>
    </div>
</form>
