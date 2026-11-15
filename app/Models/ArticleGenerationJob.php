<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleGenerationJob extends Model
{
    protected $fillable = [
        'seo_keyword_id',
        'site',
        'keyword',
        'status',
        'make_execution_id',
        'callback_token_hash',
        'error_message',
        'blog_id',
        'payload',
        'response',
    ];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
    ];

    public function seoKeyword()
    {
        return $this->belongsTo(SeoKeyword::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
