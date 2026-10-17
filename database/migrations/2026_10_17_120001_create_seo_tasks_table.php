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
        Schema::create('seo_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority')->default('medium')->comment('low, medium, high');
            $table->string('status')->default('todo')->comment('todo, in_progress, done');
            $table->date('due_date')->nullable();
            $table->foreignId('seo_keyword_id')->nullable()->constrained('seo_keywords')->nullOnDelete();
            $table->string('related_url')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_tasks');
    }
};
