<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Setting keys used by the advertisement banner on the blog single page.
     *
     * @var array<int, array<string, mixed>>
     */
    private array $settings = [
        ['key' => 'ads_banner_active', 'value' => '0', 'type' => 'boolean', 'group' => 'ads'],
        ['key' => 'ads_banner_image', 'value' => null, 'type' => 'image', 'group' => 'ads'],
        ['key' => 'ads_banner_link', 'value' => null, 'type' => 'text', 'group' => 'ads'],
        ['key' => 'ads_banner_title', 'value' => null, 'type' => 'text', 'group' => 'ads'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        foreach ($this->settings as $setting) {
            DB::table('settings')->insertOrIgnore(
                $setting + ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')
            ->whereIn('key', array_column($this->settings, 'key'))
            ->delete();
    }
};
