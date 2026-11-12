<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUSES = [
        self::STATUS_DRAFT => 'پیش‌نویس',
        self::STATUS_PUBLISHED => 'منتشرشده',
    ];

    protected $fillable = ['title', 'slug', 'description', 'image', 'summary', 'status'];

    /**
     * Only articles that are visible on the public site.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Resolve a route key by slug first, then by id (for legacy URLs).
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if (is_numeric($value)) {
            return $this->where('id', $value)->first();
        }

        return $this->where('slug', $value)->first();
    }

    /**
     * Public URL of the article: slug-based, falling back to id when no slug.
     */
    public function routeUrl(): string
    {
        return url('blog', $this->slug ?: $this->id);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function getReadingTimeAttribute()
    {
        // ۱. اگر متن خالی بود، 1 دقیقه برگردان
        if (! $this->description) {
            return 1;
        }

        // ۲. حذف کدهای HTML از متن (تا تگ‌ها به عنوان کلمه شمرده نشوند)
        $cleanText = strip_tags($this->description);

        // ۳. شمارش دقیق کلمات با پشتیبانی کامل از زبان‌های فارسی، عربی و انگلیسی (UTF-8)
        $wordCount = count(preg_split('~[^\p{L}\p{N}\']+~u', $cleanText));

        // ۴. سرعت متوسط خواندن (200 کلمه در دقیقه)
        $wordsPerMinute = 200;

        // ۵. محاسبه زمان و گرد کردن آن به سمت بالا (مثلا 1.2 دقیقه می‌شود 2 دقیقه)
        $minutes = ceil($wordCount / $wordsPerMinute);

        // حداقل زمان مطالعه را 1 دقیقه در نظر می‌گیریم
        return $minutes > 0 ? $minutes : 1;
    }
}
