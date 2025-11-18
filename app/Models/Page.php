<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title','slug','text','image'];

    public function banner()
    {
        return $this->hasMany(Banner::class);
    }

    public function extraData()
    {
        return match ($this->slug) {

            'home' => [
                'services' => Service::latest()->take(3)->get(),
                'blogs' => Blog::latest()->take(3)->get(),
                'banners' => $this->banner()->get(),
            ],

            'services' => [
                'services' => Service::all(),
                'banners' => $this->banner()->get(),
            ],

            'blog' => [
                'blogs' => Blog::latest()->paginate(10),
                'banners' => $this->banner()->get(),
            ],

            'about-us' => [
                'banners' => $this->banner()->get(),
                'services' => Service::latest()->take(3)->get(),
            ],

            'contact' => [
                'banners' => $this->banner()->get(),
            ],

            default => [],
        };
    }

}
