<?php

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('automation/articles', function () {
    $articles = Blog::query()
        ->select('title', 'description', 'summary')
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
    ]);

    return response()->json([
        'success' => true,
        'message' => 'مقاله با موفقیت ذخیره شد.',
        'article' => $blog,
    ], 201);
});
