<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoKeyword;
use App\Support\Csv;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SeoKeywordController extends Controller
{
    private const SORTABLE = [
        'keyword',
        'search_volume',
        'difficulty',
        'intent',
        'status',
        'current_rank',
        'open_tasks_count',
        'created_at',
    ];

    public function index(Request $request)
    {
        $keywords = $this->filteredQuery($request)
            ->paginate(10)
            ->withQueryString();

        return view('admin.seo.keywords.index', compact('keywords'));
    }

    public function create()
    {
        return view('admin.seo.keywords.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        SeoKeyword::create($data);

        return redirect()->route('admin.seo.keywords.index')->with('success', 'کلمه کلیدی با موفقیت اضافه شد.');
    }

    public function edit(SeoKeyword $keyword)
    {
        return view('admin.seo.keywords.edit', compact('keyword'));
    }

    public function update(Request $request, SeoKeyword $keyword)
    {
        $rules = $this->rules();
        $rules['keyword'] = ['required', 'string', 'max:255', Rule::unique('seo_keywords', 'keyword')->ignore($keyword->id)];

        $data = $request->validate($rules, $this->messages(), $this->attributes());

        $keyword->update($data);

        return redirect()->route('admin.seo.keywords.index')->with('success', 'کلمه کلیدی با موفقیت بروزرسانی شد.');
    }

    public function updateStatus(Request $request, SeoKeyword $keyword)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(SeoKeyword::STATUSES))],
        ], [
            'status.required' => 'انتخاب وضعیت الزامی است.',
            'status.in' => 'وضعیت انتخاب‌شده معتبر نیست.',
        ], [
            'status' => 'وضعیت',
        ]);

        $keyword->update($data);

        return back()->with('success', 'وضعیت کلمه کلیدی بروزرسانی شد.');
    }

    public function destroy(SeoKeyword $keyword)
    {
        $keyword->delete();

        return redirect()->route('admin.seo.keywords.index')->with('success', 'کلمه کلیدی حذف شد.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv' => ['required', 'file', 'max:5120'],
        ], [
            'csv.required' => 'انتخاب فایل CSV الزامی است.',
            'csv.file' => 'فایل ارسال‌شده معتبر نیست.',
            'csv.max' => 'حجم فایل نباید بیشتر از ۵ مگابایت باشد.',
        ]);

        try {
            $rows = Csv::rows($request->file('csv'));
        } catch (\Throwable $exception) {
            return back()->with('error', 'خواندن فایل CSV ممکن نشد: '.$exception->getMessage());
        }

        if ($rows === []) {
            return back()->with('error', 'فایل CSV هیچ ردیف داده‌ای ندارد.');
        }

        if (! array_key_exists('keyword', $rows[0])) {
            return back()->with('error', 'ستون «keyword» یا «کلمه کلیدی» در ردیف اول فایل پیدا نشد.');
        }

        $errors = [];
        $imported = 0;
        $existing = SeoKeyword::query()
            ->pluck('keyword')
            ->map(fn ($keyword) => mb_strtolower(trim($keyword)))
            ->flip();
        $seen = [];

        foreach ($rows as $row) {
            $line = $row['__line'] ?? '?';
            $keyword = trim($row['keyword'] ?? '');

            if ($keyword === '') {
                $errors[] = "سطر {$line}: کلمه کلیدی خالی است.";

                continue;
            }

            $normalizedKeyword = mb_strtolower($keyword);

            if ($existing->has($normalizedKeyword) || isset($seen[$normalizedKeyword])) {
                $errors[] = "سطر {$line}: «{$keyword}» قبلاً ثبت شده و دوباره وارد نشد.";

                continue;
            }

            $difficultyRaw = trim($row['difficulty'] ?? '');
            $intentRaw = trim($row['intent'] ?? '');
            $statusRaw = trim($row['status'] ?? '');

            $difficulty = Csv::enum($difficultyRaw, SeoKeyword::DIFFICULTIES);
            $intent = Csv::enum($intentRaw, SeoKeyword::INTENTS);
            $status = Csv::enum($statusRaw, SeoKeyword::STATUSES);

            if ($difficultyRaw !== '' && $difficulty === null) {
                $errors[] = "سطر {$line}: مقدار سختی «{$difficultyRaw}» معتبر نیست.";

                continue;
            }

            if ($intentRaw !== '' && $intent === null) {
                $errors[] = "سطر {$line}: مقدار قصد «{$intentRaw}» معتبر نیست.";

                continue;
            }

            if ($statusRaw !== '' && $status === null) {
                $errors[] = "سطر {$line}: مقدار وضعیت «{$statusRaw}» معتبر نیست.";

                continue;
            }

            $searchVolume = Csv::normalizeDigits($row['search_volume'] ?? '');
            $currentRank = Csv::normalizeDigits($row['current_rank'] ?? '');

            $data = [
                'keyword' => $keyword,
                'search_volume' => $searchVolume === '' ? null : $searchVolume,
                'difficulty' => $difficulty,
                'intent' => $intent,
                'status' => $status ?? 'idea',
                'target_url' => trim($row['target_url'] ?? '') ?: null,
                'current_rank' => $currentRank === '' ? null : $currentRank,
                'notes' => trim($row['notes'] ?? '') ?: null,
            ];

            $validator = Validator::make($data, $this->rules(), $this->messages(), $this->attributes());

            if ($validator->fails()) {
                $errors[] = "سطر {$line}: ".$validator->errors()->first();

                continue;
            }

            SeoKeyword::create($data);

            $seen[$normalizedKeyword] = true;
            $imported++;
        }

        $successMessage = "{$imported} کلمه کلیدی با موفقیت وارد شد.";

        if ($imported === 0) {
            return back()
                ->with('error', 'هیچ ردیفی وارد نشد. جزئیات خطاها را بررسی کنید.')
                ->with('import_errors', array_slice($errors, 0, 25));
        }

        return back()
            ->with('success', $successMessage)
            ->with('import_errors', array_slice($errors, 0, 25));
    }

    public function importTemplate()
    {
        $headers = ['keyword', 'search_volume', 'difficulty', 'intent', 'status', 'target_url', 'current_rank', 'notes'];
        $sample = ['طراحی سایت', '1200', 'medium', 'commercial', 'idea', '/', '12', 'نمونه ردیف'];

        return response()->streamDownload(function () use ($headers, $sample) {
            $stream = fopen('php://output', 'w');
            fwrite($stream, "\xEF\xBB\xBF");
            fputcsv($stream, $headers);
            fputcsv($stream, $sample);
            fclose($stream);
        }, 'seo-keywords-template.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function export(Request $request)
    {
        $keywords = $this->filteredQuery($request)->get();

        return response()->streamDownload(function () use ($keywords) {
            $stream = fopen('php://output', 'w');

            if ($stream === false) {
                return;
            }

            $value = fn ($item) => $item === null ? '' : (string) $item;

            fwrite($stream, "\xEF\xBB\xBF");
            fputcsv($stream, ['keyword', 'search_volume', 'difficulty', 'intent', 'status', 'target_url', 'current_rank', 'notes']);

            foreach ($keywords as $keyword) {
                fputcsv($stream, [
                    $value($keyword->keyword),
                    $value($keyword->search_volume),
                    $value($keyword->difficulty),
                    $value($keyword->intent),
                    $value($keyword->status),
                    $value($keyword->target_url),
                    $value($keyword->current_rank),
                    $value($keyword->notes),
                ]);
            }

            fclose($stream);
        }, 'seo-keywords-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filteredQuery(Request $request): Builder
    {
        $sort = (string) $request->input('sort', 'created_at');

        if (! in_array($sort, self::SORTABLE, true)) {
            $sort = 'created_at';
        }

        $direction = $request->input('direction') === 'asc' ? 'asc' : 'desc';

        return SeoKeyword::query()
            ->withCount(['tasks as open_tasks_count' => fn ($query) => $query->where('status', '!=', 'done')])
            ->when($request->filled('search'), fn ($query) => $query->where('keyword', 'like', '%'.$request->search.'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($sort === 'difficulty', fn ($query) => $query->orderByRaw(
                "CASE difficulty WHEN 'low' THEN 1 WHEN 'medium' THEN 2 WHEN 'high' THEN 3 ELSE 4 END {$direction}"
            ))
            ->when($sort === 'intent', fn ($query) => $query->orderByRaw(
                "CASE intent WHEN 'informational' THEN 1 WHEN 'commercial' THEN 2 WHEN 'transactional' THEN 3 WHEN 'navigational' THEN 4 ELSE 5 END {$direction}"
            ))
            ->when($sort === 'status', fn ($query) => $query->orderByRaw(
                "CASE status WHEN 'idea' THEN 1 WHEN 'planned' THEN 2 WHEN 'writing' THEN 3 WHEN 'published' THEN 4 WHEN 'needs_improvement' THEN 5 ELSE 6 END {$direction}"
            ))
            ->when(! in_array($sort, ['difficulty', 'intent', 'status'], true), fn ($query) => $query->orderBy($sort, $direction));
    }

    private function rules(): array
    {
        return [
            'keyword' => ['required', 'string', 'max:255', 'unique:seo_keywords,keyword'],
            'search_volume' => ['nullable', 'integer', 'min:0'],
            'difficulty' => ['nullable', Rule::in(array_keys(SeoKeyword::DIFFICULTIES))],
            'intent' => ['nullable', Rule::in(array_keys(SeoKeyword::INTENTS))],
            'status' => ['required', Rule::in(array_keys(SeoKeyword::STATUSES))],
            'target_url' => ['nullable', 'string', 'max:255'],
            'current_rank' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    private function messages(): array
    {
        return [
            'required' => 'فیلد :attribute الزامی است.',
            'string' => 'فیلد :attribute باید متن باشد.',
            'integer' => 'فیلد :attribute باید یک عدد صحیح باشد.',
            'min' => 'فیلد :attribute نباید کمتر از :min باشد.',
            'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
            'in' => 'مقدار انتخاب‌شده برای :attribute معتبر نیست.',
            'unique' => 'این :attribute قبلاً ثبت شده است.',
        ];
    }

    private function attributes(): array
    {
        return [
            'keyword' => 'کلمه کلیدی',
            'search_volume' => 'حجم جستجو',
            'difficulty' => 'سختی',
            'intent' => 'قصد کاربر',
            'status' => 'وضعیت',
            'target_url' => 'آدرس هدف',
            'current_rank' => 'رتبه فعلی',
            'notes' => 'یادداشت',
        ];
    }
}
