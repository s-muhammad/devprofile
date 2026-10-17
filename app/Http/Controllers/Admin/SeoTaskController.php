<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoKeyword;
use App\Models\SeoTask;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SeoTaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = SeoTask::query()
            ->with('keyword:id,keyword')
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->search.'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->priority))
            ->orderByRaw("CASE WHEN status = 'done' THEN 1 ELSE 0 END")
            ->orderByRaw('due_date IS NULL')
            ->orderBy('due_date')
            ->latest()
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
