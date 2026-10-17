<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTask extends Model
{
    public const PRIORITIES = [
        'low' => 'کم',
        'medium' => 'متوسط',
        'high' => 'زیاد',
    ];

    public const STATUSES = [
        'todo' => 'انجام نشده',
        'in_progress' => 'در حال انجام',
        'done' => 'انجام شده',
    ];

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'seo_keyword_id',
        'related_url',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function keyword()
    {
        return $this->belongsTo(SeoKeyword::class, 'seo_keyword_id');
    }

    public function isDone(): bool
    {
        return $this->status === 'done';
    }

    public function isOverdue(): bool
    {
        return ! $this->isDone() && $this->due_date && $this->due_date->isPast();
    }

    public function priorityLabel(): string
    {
        return self::PRIORITIES[$this->priority] ?? $this->priority;
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
