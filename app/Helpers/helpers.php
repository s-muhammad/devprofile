<?php


use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * گرفتن مقدار تنظیمات بر اساس کلید
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting->value ?? $default;
    }
}
