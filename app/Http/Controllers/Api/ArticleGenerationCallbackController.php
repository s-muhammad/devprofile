<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArticleGenerationJob;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ArticleGenerationCallbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_id' => ['required', 'integer', 'min:1'],
            'callback_token' => ['required', 'string', 'min:32', 'max:128'],
            'status' => ['required', 'in:completed,failed'],
            'error' => ['nullable', 'string', 'max:2000'],
            'article' => ['required_if:status,completed', 'array'],
            'article.title' => ['required_if:status,completed', 'string', 'max:255'],
            'article.content' => ['required_if:status,completed', 'string', 'min:100'],
            'article.excerpt' => ['required_if:status,completed', 'string', 'max:255'],
            'article.image_base64' => ['required_if:status,completed', 'string', 'max:7000000'],
            'article.image_mime_type' => ['required_if:status,completed', 'in:image/png,image/jpeg,image/webp'],
        ]);

        $job = ArticleGenerationJob::find($validated['job_id']);

        if (! $job || ! $job->callback_token_hash ||
            ! hash_equals($job->callback_token_hash, hash('sha256', $validated['callback_token']))) {
            return response()->json(['success' => false, 'message' => 'Invalid callback credentials.'], 403);
        }

        if ($job->status === 'completed' && $job->blog_id) {
            return response()->json([
                'success' => true,
                'message' => 'This job was already completed.',
                'blog_id' => $job->blog_id,
            ]);
        }

        if ($job->status !== 'processing') {
            return response()->json(['success' => false, 'message' => 'This job is not processing.'], 409);
        }

        if ($validated['status'] === 'failed') {
            DB::transaction(function () use ($job, $validated) {
                $job->update([
                    'status' => 'failed',
                    'error_message' => $validated['error'] ?? 'Article generation failed in Make.',
                    'response' => ['callback' => 'failed'],
                ]);

                $job->seoKeyword()->where('status', 'writing')->update(['status' => 'planned']);
            });

            return response()->json(['success' => true, 'message' => 'Failure status recorded.']);
        }

        $imageBase64 = preg_replace('/^data:image\/[a-zA-Z0-9.+-]+;base64,/', '', $validated['article']['image_base64']);
        $imageBytes = base64_decode($imageBase64, true);

        if ($imageBytes === false || strlen($imageBytes) > 5 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'article.image_base64' => 'The generated image is invalid or exceeds 5 MB.',
            ]);
        }

        $mimeToExtension = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg',
            'image/webp' => 'webp',
        ];
        $extension = $mimeToExtension[$validated['article']['image_mime_type']];
        $imagePath = 'articles/'.Str::uuid().'.'.$extension;

        Storage::disk('public')->put($imagePath, $imageBytes);

        try {
            $blog = DB::transaction(function () use ($job, $validated, $imagePath) {
                $lockedJob = ArticleGenerationJob::query()->lockForUpdate()->findOrFail($job->id);

                if ($lockedJob->status === 'completed' && $lockedJob->blog_id) {
                    return Blog::findOrFail($lockedJob->blog_id);
                }

                $title = trim($validated['article']['title']);
                $slug = (Str::slug($title) ?: 'article-'.$lockedJob->id).'-'.$lockedJob->id;

                $blog = Blog::create([
                    'title' => $title,
                    'slug' => $slug,
                    'description' => $validated['article']['content'],
                    'image' => $imagePath,
                    'summary' => trim($validated['article']['excerpt']),
                    'status' => Blog::STATUS_DRAFT,
                ]);

                $lockedJob->update([
                    'status' => 'completed',
                    'blog_id' => $blog->id,
                    'error_message' => null,
                    'response' => ['callback' => 'completed', 'blog_id' => $blog->id],
                ]);

                $lockedJob->seoKeyword()->where('status', 'writing')->update(['status' => 'planned']);

                return $blog;
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($imagePath);
            throw $exception;
        }

        return response()->json([
            'success' => true,
            'message' => 'Article saved as draft.',
            'blog_id' => $blog->id,
            'slug' => $blog->slug,
        ], 201);
    }
}
