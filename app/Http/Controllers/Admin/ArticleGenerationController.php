<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleGenerationJob;
use App\Models\SeoKeyword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ArticleGenerationController extends Controller
{
    public function store(SeoKeyword $keyword): RedirectResponse
    {
        if (! in_array($keyword->status, ['planned', 'idea'], true)) {
            return back()->with('error', 'برای تولید مقاله، وضعیت کلمه باید «ایده» یا «برنامه‌ریزی شده» باشد.');
        }

        $activeJob = ArticleGenerationJob::query()
            ->where('seo_keyword_id', $keyword->id)
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->first();

        if ($activeJob) {
            return back()->with('error', 'برای این کلمه کلیدی یک درخواست فعال وجود دارد (شناسه: '.$activeJob->id.').');
        }

        $webhookUrl = config('services.make.article_webhook_url');
        $site = rtrim((string) config('services.make.site_url'), '/');
        $callbackUrl = config('services.make.article_callback_url')
            ?: $site.'/api/automation/articles/callback';

        $siteHost = strtolower((string) parse_url($site, PHP_URL_HOST));
        $callbackHost = strtolower((string) parse_url($callbackUrl, PHP_URL_HOST));
        $isLocalHost = static fn (string $host): bool =>
            in_array($host, ['localhost', '127.0.0.1', '::1'], true)
            || str_ends_with($host, '.local')
            || str_ends_with($host, '.test');

        if (
            ! $webhookUrl
            || ! filter_var($site, FILTER_VALIDATE_URL)
            || ! filter_var($callbackUrl, FILTER_VALIDATE_URL)
            || strtolower((string) parse_url($site, PHP_URL_SCHEME)) !== 'https'
            || strtolower((string) parse_url($callbackUrl, PHP_URL_SCHEME)) !== 'https'
            || $isLocalHost($siteHost)
            || $isLocalHost($callbackHost)
        ) {
            return back()->with('error', 'آدرس سایت و Callback باید دامنه عمومی HTTPS و قابل دسترسی از اینترنت باشند. متغیرهای MAKE_ARTICLE_WEBHOOK_URL، SEO_SITE_URL و MAKE_ARTICLE_CALLBACK_URL را بررسی کنید.');
        }

        $callbackToken = Str::random(64);

        $job = ArticleGenerationJob::create([
            'seo_keyword_id' => $keyword->id,
            'site' => $site,
            'keyword' => $keyword->keyword,
            'status' => 'processing',
            'callback_token_hash' => hash('sha256', $callbackToken),
        ]);

        $payload = [
            'site' => $site,
            'keyword_id' => $keyword->id,
            'keyword' => $keyword->keyword,
            'intent' => $keyword->intent ?: 'informational',
            'callback_url' => $callbackUrl,
            'job_id' => $job->id,
        ];

        $job->update(['payload' => $payload]);
        $keyword->update(['status' => 'writing']);

        try {
            $caBundle = storage_path('app/cacert.pem');
            $http = Http::acceptJson()->asJson()->timeout(20);

            if (is_file($caBundle)) {
                $http = $http->withOptions(['verify' => $caBundle]);
            }

            $response = $http->post($webhookUrl, $payload + ['callback_token' => $callbackToken]);

            if (! $response->successful()) {
                $job->refresh();

                if ($job->status !== 'completed') {
                    $job->update([
                        'status' => 'failed',
                        'error_message' => 'Make webhook returned HTTP '.$response->status(),
                        'response' => ['body' => mb_substr($response->body(), 0, 2000)],
                    ]);

                    $keyword->newQuery()
                        ->whereKey($keyword->id)
                        ->where('status', 'writing')
                        ->update(['status' => 'planned']);
                }

                Log::warning('Make article webhook rejected the request.', [
                    'job_id' => $job->id,
                    'http_status' => $response->status(),
                ]);

                return back()->with('error', 'ارسال درخواست به Make ناموفق بود. شناسه درخواست: '.$job->id);
            }

            $job->refresh();

            if ($job->status === 'processing') {
                $job->update(['response' => $response->json() ?? []]);
            }

            return back()->with('success', 'درخواست تولید مقاله برای «'.$keyword->keyword.'» به Make ارسال شد. شناسه: '.$job->id);
        } catch (\Throwable $exception) {
            $job->refresh();

            if ($job->status !== 'completed') {
                $job->update([
                    'status' => 'failed',
                    'error_message' => mb_substr($exception->getMessage(), 0, 2000),
                ]);

                $keyword->newQuery()
                    ->whereKey($keyword->id)
                    ->where('status', 'writing')
                    ->update(['status' => 'planned']);
            }

            Log::error('Could not send article generation request to Make.', [
                'job_id' => $job->id,
                'exception' => $exception::class,
            ]);

            return back()->with('error', 'ارتباط با سرویس Make برقرار نشد. شناسه درخواست: '.$job->id);
        }
    }
}
