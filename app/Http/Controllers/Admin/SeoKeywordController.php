<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoKeyword;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SeoKeywordController extends Controller
{
    public function index(Request $request)
    {
        $keywords = SeoKeyword::query()
            ->withCount(['tasks as open_tasks_count' => fn ($query) => $query->where('status', '!=', 'done')])
            ->when($request->filled('search'), fn ($query) => $query->where('keyword', 'like', '%'.$request->search.'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
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
