<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/',function(){
        $blogs = \App\Models\Blog::latest()->take(3)->get();
        $services = \App\Models\Service::latest()->take(3)->get();
        return view('admin.index',compact('services','blogs'));
    })->name('index');
    Route::resource('blog',BlogController::class);
    Route::resource('user',UserController::class);
    Route::resource('setting',SettingController::class)->only(['index','update']);
    Route::resource('page',PageController::class)->only(['index','update','edit']);
    Route::resource('service',ServiceController::class);
    Route::resource('banner',BannerController::class);
});

Route::get('blog/{blog}',function ($blog){
    $blog = Blog::find($blog);
    return view('blog.show',compact('blog'));
})->name('blog.single');

Route::get('login', [LoginController::class, 'loginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'registrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.post');

Route::get('{slug?}', function ($slug = null) {
    $targetSlug = $slug ?? 'home';
    $page = Page::where('slug', $targetSlug)->firstOrFail();
    return view($page->view, [
        'page' => $page,
        ...$page->extraData()
    ]);
})->name('page.show');
