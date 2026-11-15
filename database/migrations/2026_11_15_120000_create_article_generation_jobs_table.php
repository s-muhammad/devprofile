<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_generation_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_keyword_id')->constrained('seo_keywords')->cascadeOnDelete();
            $table->string('site');
            $table->string('keyword');
            $table->string('status')->default('pending')->index();
            $table->string('make_execution_id')->nullable();
            $table->text('error_message')->nullable();
            $table->foreignId('blog_id')->nullable()->constrained('blogs')->nullOnDelete();
            $table->json('payload')->nullable();
            $table->json('response')->nullable();
            $table->timestamps();

            $table->index(['seo_keyword_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_generation_jobs');
    }
};
