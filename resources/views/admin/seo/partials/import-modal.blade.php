@php
    $modalId = $modalId ?? 'seo-import-modal';
    $columns = $columns ?? [];
@endphp

<div id="{{ $modalId }}" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" data-import-close></div>

        <div class="relative bg-white w-full max-w-xl rounded-2xl shadow-2xl p-6 md:p-8">
            <div class="flex items-start justify-between mb-5">
                <h3 class="text-xl font-extrabold text-gray-800">
                    <i class="fas fa-file-import text-blue-600 ml-2"></i>
                    {{ $title }}
                </h3>
                <button type="button" data-import-close
                        class="text-gray-400 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="{{ $modalId }}-file" class="block text-sm font-semibold text-gray-700 mb-2">
                        فایل CSV
                    </label>
                    <input type="file" id="{{ $modalId }}-file" name="csv" accept=".csv,text/csv,text/plain" required
                           class="block w-full text-sm text-gray-600 border border-gray-200 rounded-lg cursor-pointer
                                  file:mr-4 file:py-2.5 file:px-4 file:border-0 file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100 transition">
                    <p class="text-xs text-gray-500 mt-2">
                        ردیف اول فایل باید عنوان ستون‌ها باشد. کدگذاری UTF-8 پیشنهاد می‌شود.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">ستون‌های قابل استفاده:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($columns as $column)
                            <span class="inline-flex items-center gap-1 text-xs bg-white border border-gray-200 rounded-full px-3 py-1">
                                <code class="text-blue-700" dir="ltr">{{ $column[0] }}</code>
                                <span class="text-gray-300">|</span>
                                <span class="text-gray-600">{{ $column[1] }}</span>
                            </span>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-3">
                        مقادیر فارسی (مثل «زیاد» یا «در حال انجام») هم به‌جای کلید انگلیسی پذیرفته می‌شوند.
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                    <a href="{{ $templateRoute }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-800 transition">
                        <i class="fas fa-download ml-1"></i> دانلود فایل نمونه
                    </a>
                    <div class="flex items-center gap-2">
                        <button type="button" data-import-close
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-5 rounded-lg transition">
                            انصراف
                        </button>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-lg shadow-blue-500/30 transition">
                            <i class="fas fa-upload ml-1"></i> شروع واردکردن
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById(@json($modalId));

        if (!modal) {
            return;
        }

        const open = () => modal.classList.remove('hidden');
        const close = () => modal.classList.add('hidden');

        document.querySelectorAll('[data-import-open="{{ $modalId }}"]').forEach((button) => {
            button.addEventListener('click', open);
        });

        modal.querySelectorAll('[data-import-close]').forEach((element) => {
            element.addEventListener('click', close);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                close();
            }
        });
    })();
</script>
