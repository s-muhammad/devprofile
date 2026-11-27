<?php

use App\Http\Controllers\Admin\ArticleGenerationController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\SeoGraphController;
use App\Http\Controllers\Admin\SeoKeywordController;
use App\Http\Controllers\Admin\SeoTaskController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;

// SEO endpoints: generated from the current public content and host.
Route::get('/sitemap.xml', function () {
    $urls = collect([
        ['loc' => url('/'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['loc' => url('/blog'), 'lastmod' => null, 'changefreq' => 'daily', 'priority' => '0.8'],
    ])->concat(
        Blog::published()->get()->map(fn (Blog $blog) => [
            'loc' => $blog->routeUrl(),
            'lastmod' => $blog->updated_at?->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ])
    );

    return response()
        ->view('sitemap', ['urls' => $urls])
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

Route::get('/robots.txt', function () {
    $content = implode("\n", [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin',
        'Disallow: /login',
        'Disallow: /blog/load-more',
        'Sitemap: ' . url('/sitemap.xml'),
        '',
    ]);

    return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->name('robots');

Route::get('/', [IndexController::class, 'index']);
Route::get('blog', [IndexController::class, 'blog']);
Route::get('blog/load-more', [IndexController::class, 'blogLoadMore'])->name('blog.loadMore');
Route::get('blog/{blog}', [IndexController::class, 'blogSingle'])->name('blog.single');
Route::post('comment', [IndexController::class, 'storeComment'])->name('comment.store');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('user', UserController::class);
    Route::resource('blog', BlogController::class);
    Route::patch('blog/{blog}/status', [BlogController::class, 'updateStatus'])->name('blog.status');
    Route::resource('projects', ProjectsController::class);
    Route::patch('projects/{project}/toggle-active', [ProjectsController::class, 'toggleActive'])->name('projects.toggleActive');
    Route::resource('comments', CommentsController::class)->only(['index', 'destroy', 'update']);
    Route::get('settings/index', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');

    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('graph', [SeoGraphController::class, 'index'])->name('graph.index');

        Route::resource('keywords', SeoKeywordController::class)->except('show');
        Route::post('keywords/import', [SeoKeywordController::class, 'import'])->name('keywords.import');
        Route::get('keywords/import/template', [SeoKeywordController::class, 'importTemplate'])->name('keywords.import.template');
        Route::get('keywords/export', [SeoKeywordController::class, 'export'])->name('keywords.export');
        Route::patch('keywords/{keyword}/status', [SeoKeywordController::class, 'updateStatus'])->name('keywords.status');
        Route::post('keywords/{keyword}/generate-article', [ArticleGenerationController::class, 'store'])
            ->name('keywords.generate-article');

        Route::resource('tasks', SeoTaskController::class)->except('show');
        Route::post('tasks/import', [SeoTaskController::class, 'import'])->name('tasks.import');
        Route::get('tasks/import/template', [SeoTaskController::class, 'importTemplate'])->name('tasks.import.template');
        Route::get('tasks/export', [SeoTaskController::class, 'export'])->name('tasks.export');
        Route::patch('tasks/{task}/toggle', [SeoTaskController::class, 'toggleStatus'])->name('tasks.toggle');
    });
});

Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('register',[AuthController::class,'registerForm'])->name('register');
// Route::post('register',[AuthController::class,'register'])->name('register.post');
