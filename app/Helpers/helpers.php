<?php

use App\Models\Settings;

if (! function_exists('setting')) {
    /**
     * گرفتن مقدار تنظیمات بر اساس کلید
     *
     * @param  mixed  $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        $setting = Settings::where('key', $key)->first();

        return $setting->value ?? $default;
    }
}

if (! function_exists('jalali_date')) {
    /**
     * تبدیل تاریخ میلادی به شمسی برای نمایش
     */
    function jalali_date($date, string $format = 'Y/m/d'): ?string
    {
        if (! $date) {
            return null;
        }

        return \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($date))->format($format);
    }
}

if (! function_exists('jalali_to_gregorian')) {
    /**
     * تبدیل تاریخ شمسی (۱۴۰۵/۰۷/۲۶) به میلادی برای ذخیره
     * در صورت نامعتبر بودن مقدار، null برمی‌گرداند.
     */
    function jalali_to_gregorian(?string $date): ?string
    {
        if (! $date) {
            return null;
        }

        $date = \Morilog\Jalali\CalendarUtils::convertNumbers(str_replace('-', '/', trim($date)), true);

        if (! preg_match('/^(\d{4})\/(\d{1,2})\/(\d{1,2})$/', $date, $matches)) {
            return null;
        }

        try {
            $jalali = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $date);
        } catch (\Throwable $e) {
            return null;
        }

        // بررسی سرریز روز/ماه (مثلاً ۱۴۰۵/۱۵/۴۰)
        if ($jalali->format('Y/m/d') !== sprintf('%04d/%02d/%02d', $matches[1], $matches[2], $matches[3])) {
            return null;
        }

        return $jalali->toCarbon()->toDateString();
    }
}
