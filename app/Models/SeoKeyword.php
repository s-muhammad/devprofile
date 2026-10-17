<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoKeyword extends Model
{
    public const STATUSES = [
        'idea' => 'ایده',
        'planned' => 'برنامه‌ریزی شده',
        'writing' => 'در حال نوشتن',
        'published' => 'منتشر شده',
        'needs_improvement' => 'نیاز به بهبود',
    ];

    public const DIFFICULTIES = [
        'low' => 'کم',
        'medium' => 'متوسط',
        'high' => 'زیاد',
    ];

    public const INTENTS = [
        'informational' => 'اطلاعاتی',
        'commercial' => 'تجاری',
        'transactional' => 'تراکنشی',
        'navigational' => 'ناوبری',
    ];

    protected $fillable = [
        'keyword',
        'search_volume',
        'difficulty',
        'intent',
        'status',
        'target_url',
        'current_rank',
        'notes',
    ];

    protected $casts = [
        'search_volume' => 'integer',
        'current_rank' => 'integer',
    ];

    public function tasks()
    {
        return $this->hasMany(SeoTask::class);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
