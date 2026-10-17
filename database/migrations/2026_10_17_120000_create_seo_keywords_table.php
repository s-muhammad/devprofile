<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->unique();
            $table->unsignedInteger('search_volume')->nullable();
            $table->string('difficulty')->nullable()->comment('low, medium, high');
            $table->string('intent')->nullable()->comment('informational, commercial, transactional, navigational');
            $table->string('status')->default('idea')->comment('idea, planned, writing, published, needs_improvement');
            $table->string('target_url')->nullable();
            $table->unsignedInteger('current_rank')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_keywords');
    }
};
