<?php

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\SeoKeyword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('automation/articles', function () {
    $articles = Blog::query()
        ->published()
        ->select('title','summary')
        ->latest()
        ->limit(100)
        ->get();

    return response()->json([
        'success' => true,
        'articles' => $articles,
    ]);
});
Route::post('automation/articles', function (\Illuminate\Http\Request $request) {

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'excerpt' => 'nullable|string',
        'image' => 'nullable|string',
    ]);

    $blog = Blog::create([
        'title' => $validated['title'],
        'description' => $validated['content'],
        'image' => $validated['image'] ?? null,
        'summary' => $validated['excerpt'] ?? null,
        'status' => Blog::STATUS_PUBLISHED,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'مقاله با موفقیت ذخیره شد.',
        'article' => $blog,
    ], 201);
});

Route::post('automation/v2/keyword-ideas', function (Request $request) {

    $validated = Validator::make($request->all(), [
        'site' => 'required|string',
        'source' => 'required|string',
        'period_days' => 'required|integer',

        'ideas' => 'required|array',
        'ideas.*.keyword' => 'required|string|max:255|distinct',
        'ideas.*.intent' => [
            'required',
            Rule::in([
                'informational',
                'commercial',
                'transactional',
                'navigational',
            ]),
        ],
        'ideas.*.priority' => [
            'required',
            Rule::in(['low', 'medium', 'high']),
        ],
        'ideas.*.opportunity_type' => 'required|string',
        'ideas.*.source_query' => 'nullable|string',
        'ideas.*.source_metrics.clicks' => 'nullable|numeric|min:0',
        'ideas.*.source_metrics.impressions' => 'nullable|numeric|min:0',
        'ideas.*.source_metrics.ctr' => 'nullable|numeric|min:0|max:1',
        'ideas.*.source_metrics.average_position' => 'nullable|numeric|min:0',
        'ideas.*.suggested_page' => 'nullable|string',
        'ideas.*.reason' => 'nullable|string',
        'ideas.*.confidence' => [
            'required',
            Rule::in(['low', 'medium', 'high']),
        ],
    ])->validate();

    $created = 0;
    $existing = 0;

    DB::transaction(function () use ($validated, &$created, &$existing) {

        foreach ($validated['ideas'] as $idea) {

            $keyword = SeoKeyword::firstOrCreate(
                [
                    'keyword' => $idea['keyword'],
                ],
                [
                    'intent' => $idea['intent'],
                    'status' => 'idea',
                    'target_url' => $idea['suggested_page'] ?? null,

                    'notes' => json_encode([
                        'site' => $validated['site'],
                        'source' => $validated['source'],
                        'period_days' => $validated['period_days'],
                        'priority' => $idea['priority'],
                        'opportunity_type' => $idea['opportunity_type'],
                        'source_query' => $idea['source_query'] ?? null,
                        'source_metrics' => $idea['source_metrics'] ?? [],
                        'reason' => $idea['reason'] ?? null,
                        'confidence' => $idea['confidence'],
                    ], JSON_UNESCAPED_UNICODE),
                ]
            );

            if ($keyword->wasRecentlyCreated) {
                $created++;
            } else {
                $existing++;
            }
        }
    });

    return response()->json([
        'success' => true,
        'message' => 'Keyword ideas processed successfully.',
        'created' => $created,
        'existing' => $existing,
        'total' => count($validated['ideas']),
    ]);
});
