<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('article_generation_jobs', function (Blueprint $table) {
            $table->string('callback_token_hash', 64)->nullable()->after('make_execution_id');
        });
    }

    public function down(): void
    {
        Schema::table('article_generation_jobs', function (Blueprint $table) {
            $table->dropColumn('callback_token_hash');
        });
    }
};
