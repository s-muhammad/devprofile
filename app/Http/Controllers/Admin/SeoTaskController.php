<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoKeyword;
use App\Models\SeoTask;
use App\Support\Csv;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SeoTaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $this->filteredQuery($request)
            ->paginate(10)
            ->withQueryString();

        return view('admin.seo.tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('admin.seo.tasks.create', ['keywords' => SeoKeyword::orderBy('keyword')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        $dueDate = $this->prepareDueDate($request);
        if ($dueDate === false) {
            return back()->withErrors(['due_date' => 'تاریخ سررسید باید به صورت شمسی و مانند ۱۴۰۵/۰۷/۲۶ وارد شود.'])->withInput();
        }
        $data['due_date'] = $dueDate;

        $data['completed_at'] = $data['status'] === 'done' ? now() : null;

        SeoTask::create($data);

        return redirect()->route('admin.seo.tasks.index')->with('success', 'کار با موفقیت اضافه شد.');
    }

    public function edit(SeoTask $task)
    {
        return view('admin.seo.tasks.edit', [
            'task' => $task,
            'keywords' => SeoKeyword::orderBy('keyword')->get(),
        ]);
    }

    public function update(Request $request, SeoTask $task)
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        $dueDate = $this->prepareDueDate($request);
        if ($dueDate === false) {
            return back()->withErrors(['due_date' => 'تاریخ سررسید باید به صورت شمسی و مانند ۱۴۰۵/۰۷/۲۶ وارد شود.'])->withInput();
        }
        $data['due_date'] = $dueDate;

        if ($data['status'] === 'done') {
            $data['completed_at'] = $task->completed_at ?? now();
        } else {
            $data['completed_at'] = null;
        }

        $task->update($data);

        return redirect()->route('admin.seo.tasks.index')->with('success', 'کار با موفقیت بروزرسانی شد.');
    }

    public function toggleStatus(SeoTask $task)
    {
        if ($task->isDone()) {
            $task->update(['status' => 'todo', 'completed_at' => null]);
        } else {
            $task->update(['status' => 'done', 'completed_at' => now()]);
        }

        return back()->with('success', 'وضعیت کار بروزرسانی شد.');
    }

    public function destroy(SeoTask $task)
    {
        $task->delete();

        return redirect()->route('admin.seo.tasks.index')->with('success', 'کار حذف شد.');
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

        if (! array_key_exists('title', $rows[0])) {
            return back()->with('error', 'ستون «title» یا «عنوان» در ردیف اول فایل پیدا نشد.');
        }

        $keywordLookup = SeoKeyword::query()
            ->get(['id', 'keyword'])
            ->keyBy(fn (SeoKeyword $keyword) => mb_strtolower(trim($keyword->keyword)));

        $errors = [];
        $imported = 0;

        foreach ($rows as $row) {
            $line = $row['__line'] ?? '?';
            $title = trim($row['title'] ?? '');

            if ($title === '') {
                $errors[] = "سطر {$line}: عنوان کار خالی است.";

                continue;
            }

            $priorityRaw = trim($row['priority'] ?? '');
            $statusRaw = trim($row['status'] ?? '');

            $priority = Csv::enum($priorityRaw, SeoTask::PRIORITIES);
            $status = Csv::enum($statusRaw, SeoTask::STATUSES);

            if ($priorityRaw !== '' && $priority === null) {
                $errors[] = "سطر {$line}: مقدار اولویت «{$priorityRaw}» معتبر نیست.";

                continue;
            }

            if ($statusRaw !== '' && $status === null) {
                $errors[] = "سطر {$line}: مقدار وضعیت «{$statusRaw}» معتبر نیست.";

                continue;
            }

            $keywordName = trim($row['keyword'] ?? '');
            $keywordIdRaw = Csv::normalizeDigits($row['seo_keyword_id'] ?? '');
            $keywordId = null;

            if ($keywordName !== '') {
                $keyword = $keywordLookup->get(mb_strtolower($keywordName));

                if (! $keyword) {
                    $errors[] = "سطر {$line}: کلمه کلیدی «{$keywordName}» پیدا نشد.";

                    continue;
                }

                $keywordId = $keyword->id;
            } elseif ($keywordIdRaw !== '') {
                $keyword = $keywordLookup->firstWhere('id', (int) $keywordIdRaw);

                if (! $keyword) {
                    $errors[] = "سطر {$line}: شناسه کلمه کلیدی «{$keywordIdRaw}» معتبر نیست.";

                    continue;
                }

                $keywordId = $keyword->id;
            }

            $dueDate = null;
            $dueDateRaw = trim($row['due_date'] ?? '');

            if ($dueDateRaw !== '') {
                $dueDate = jalali_to_gregorian($dueDateRaw);

                if ($dueDate === null) {
                    $errors[] = "سطر {$line}: تاریخ سررسید «{$dueDateRaw}» معتبر نیست. نمونه صحیح: ۱۴۰۵/۰۸/۰۱";

                    continue;
                }
            }

            $data = [
                'title' => $title,
                'description' => trim($row['description'] ?? '') ?: null,
                'priority' => $priority ?? 'medium',
                'status' => $status ?? 'todo',
                'due_date' => $dueDate,
                'seo_keyword_id' => $keywordId,
                'related_url' => trim($row['related_url'] ?? '') ?: null,
            ];

            $validator = Validator::make($data, $this->rules(), $this->messages(), $this->attributes());

            if ($validator->fails()) {
                $errors[] = "سطر {$line}: ".$validator->errors()->first();

                continue;
            }

            $data['completed_at'] = $data['status'] === 'done' ? now() : null;

            SeoTask::create($data);

            $imported++;
        }

        $successMessage = "{$imported} کار با موفقیت وارد شد.";

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
        $headers = ['title', 'description', 'priority', 'status', 'due_date', 'keyword', 'related_url'];
        $sample = ['بهینه‌سازی سرعت صفحه اصلی', 'بررسی و بهبود Core Web Vitals', 'high', 'todo', '۱۴۰۵/۰۸/۰۱', 'طراحی سایت', '/'];

        return response()->streamDownload(function () use ($headers, $sample) {
            $stream = fopen('php://output', 'w');
            fwrite($stream, "\xEF\xBB\xBF");
            fputcsv($stream, $headers);
            fputcsv($stream, $sample);
            fclose($stream);
        }, 'seo-tasks-template.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function export(Request $request)
    {
        $tasks = $this->filteredQuery($request)->get();

        return response()->streamDownload(function () use ($tasks) {
            $stream = fopen('php://output', 'w');

            if ($stream === false) {
                return;
            }

            $value = fn ($item) => $item === null ? '' : (string) $item;

            fwrite($stream, "\xEF\xBB\xBF");
            fputcsv($stream, ['title', 'description', 'priority', 'status', 'due_date', 'keyword', 'related_url']);

            foreach ($tasks as $task) {
                fputcsv($stream, [
                    $value($task->title),
                    $value($task->description),
                    $value($task->priority),
                    $value($task->status),
                    $value(jalali_date($task->due_date)),
                    $value($task->keyword->keyword ?? null),
                    $value($task->related_url),
                ]);
            }

            fclose($stream);
        }, 'seo-tasks-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filteredQuery(Request $request): Builder
    {
        $query = SeoTask::query()
            ->with('keyword:id,keyword')
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->search.'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->priority));

        $sortable = ['title', 'keyword', 'priority', 'status', 'due_date'];
        $sort = $request->input('sort');
        $direction = $request->input('direction') === 'desc' ? 'desc' : 'asc';

        if (in_array($sort, $sortable, true)) {
            if ($sort === 'keyword') {
                $query->leftJoin('seo_keywords', 'seo_tasks.seo_keyword_id', '=', 'seo_keywords.id')
                    ->select('seo_tasks.*')
                    ->orderBy('seo_keywords.keyword', $direction);
            } elseif ($sort === 'priority') {
                $query->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END {$direction}");
            } elseif ($sort === 'status') {
                $query->orderByRaw("CASE status WHEN 'todo' THEN 1 WHEN 'in_progress' THEN 2 WHEN 'done' THEN 3 ELSE 4 END {$direction}");
            } else {
                $query->orderBy($sort, $direction);
            }

            return $query->orderBy('seo_tasks.id', 'desc');
        }

        return $query
            ->orderByRaw("CASE WHEN status = 'done' THEN 1 ELSE 0 END")
            ->orderByRaw('due_date IS NULL')
            ->orderBy('due_date')
            ->latest('seo_tasks.created_at');
    }

    /**
     * تبدیل ورودی شمسی به میلادی؛ در صورت خالی بودن null و در صورت نامعتبر بودن false.
     */
    private function prepareDueDate(Request $request)
    {
        if (! $request->filled('due_date')) {
            return null;
        }

        $gregorian = jalali_to_gregorian($request->due_date);

        return $gregorian ?? false;
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', Rule::in(array_keys(SeoTask::PRIORITIES))],
            'status' => ['required', Rule::in(array_keys(SeoTask::STATUSES))],
            'due_date' => ['nullable', 'string', 'max:10'],
            'seo_keyword_id' => ['nullable', 'integer', 'exists:seo_keywords,id'],
            'related_url' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function messages(): array
    {
        return [
            'required' => 'فیلد :attribute الزامی است.',
            'string' => 'فیلد :attribute باید متن باشد.',
            'integer' => 'فیلد :attribute معتبر نیست.',
            'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
            'in' => 'مقدار انتخاب‌شده برای :attribute معتبر نیست.',
            'exists' => 'کلمه کلیدی انتخاب‌شده معتبر نیست.',
        ];
    }

    private function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'description' => 'توضیحات',
            'priority' => 'اولویت',
            'status' => 'وضعیت',
            'due_date' => 'تاریخ سررسید',
            'seo_keyword_id' => 'کلمه کلیدی',
            'related_url' => 'آدرس مرتبط',
        ];
    }
}
