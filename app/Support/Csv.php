<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use RuntimeException;

class Csv
{
    /**
     * نام‌های قابل قبول برای هر ستون (انگلیسی و فارسی).
     *
     * @var array<string, array<int, string>>
     */
    private const HEADER_ALIASES = [
        'keyword' => ['keyword', 'keywords', 'کلمه کلیدی', 'کلمه‌کلیدی', 'کلمه'],
        'search_volume' => ['search_volume', 'search volume', 'searchvolume', 'volume', 'حجم جستجو', 'حجم جست‌وجو', 'حجم'],
        'difficulty' => ['difficulty', 'سختی'],
        'intent' => ['intent', 'قصد', 'قصد کاربر', 'نیت', 'نیت کاربر'],
        'status' => ['status', 'وضعیت'],
        'target_url' => ['target_url', 'target url', 'targeturl', 'آدرس هدف', 'لینک هدف'],
        'current_rank' => ['current_rank', 'current rank', 'currentrank', 'rank', 'رتبه', 'رتبه فعلی'],
        'notes' => ['notes', 'note', 'یادداشت', 'یادداشت‌ها'],
        'title' => ['title', 'عنوان'],
        'description' => ['description', 'توضیحات', 'شرح'],
        'priority' => ['priority', 'اولویت'],
        'due_date' => ['due_date', 'due date', 'duedate', 'due', 'سررسید', 'تاریخ سررسید'],
        'seo_keyword_id' => ['seo_keyword_id', 'seo keyword id', 'seokeywordid', 'keyword_id', 'keyword id', 'شناسه کلمه کلیدی', 'آیدی کلمه کلیدی'],
        'related_url' => ['related_url', 'related url', 'relatedurl', 'آدرس مرتبط', 'لینک مرتبط'],
    ];

    private const DIGITS = [
        '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
        '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
        '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
        '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
    ];

    /**
     * خواندن فایل CSV و برگرداندن ردیف‌ها به صورت آرایه‌ای با کلیدهای انگلیسی.
     *
     * @return array<int, array<string, string>>
     *
     * @throws RuntimeException
     */
    public static function rows(UploadedFile $file): array
    {
        $path = $file->getRealPath();

        if ($path === false || ! is_readable($path)) {
            throw new RuntimeException('فایل ارسال‌شده قابل خواندن نیست.');
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException('فایل ارسال‌شده قابل خواندن نیست.');
        }

        $contents = self::toUtf8($contents);
        $contents = preg_replace('/^\xEF\xBB\xBF/', '', $contents) ?? $contents;

        if (trim($contents) === '') {
            throw new RuntimeException('فایل CSV خالی است.');
        }

        $delimiter = self::detectDelimiter($contents);

        $stream = fopen('php://temp', 'r+');

        if ($stream === false) {
            throw new RuntimeException('پردازش فایل CSV ممکن نشد.');
        }

        fwrite($stream, $contents);
        rewind($stream);

        $headerRow = fgetcsv($stream, 0, $delimiter);

        if ($headerRow === false) {
            fclose($stream);
            throw new RuntimeException('ردیف عنوان ستون‌ها در فایل پیدا نشد.');
        }

        $map = [];

        foreach ($headerRow as $index => $header) {
            $key = self::headerKey($header);

            if ($key !== null) {
                $map[$index] = $key;
            }
        }

        if ($map === []) {
            fclose($stream);
            throw new RuntimeException('هیچ ستون شناخته‌شده‌ای در ردیف اول فایل پیدا نشد. عنوان ستون‌ها را بررسی کنید.');
        }

        $rows = [];
        $line = 1;

        while (($cells = fgetcsv($stream, 0, $delimiter)) !== false) {
            $line++;

            if (self::isEmptyRow($cells)) {
                continue;
            }

            $row = ['__line' => (string) $line];

            foreach ($map as $index => $key) {
                $row[$key] = isset($cells[$index]) ? trim((string) $cells[$index]) : '';
            }

            $rows[] = $row;
        }

        fclose($stream);

        return $rows;
    }

    /**
     * تبدیل مقدار ورودی (کلید انگلیسی یا برچسب فارسی) به کلید معتبر.
     *
     * @param  array<string, string>  $map
     */
    public static function enum(?string $value, array $map): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        $normalized = self::normalizeValue($value);

        foreach ($map as $key => $label) {
            if (self::normalizeValue($key) === $normalized || self::normalizeValue($label) === $normalized) {
                return $key;
            }
        }

        return null;
    }

    /**
     * یکسان‌سازی ارقام فارسی/عربی و حذف جداکننده‌های هزارگان.
     */
    public static function normalizeDigits(?string $value): string
    {
        $value = strtr(trim((string) $value), self::DIGITS);

        return str_replace([',', '،', '٬', ' ', '٫', "\u{200C}"], '', $value);
    }

    private static function headerKey(?string $header): ?string
    {
        $normalized = self::normalizeHeader((string) $header);

        if ($normalized === '') {
            return null;
        }

        foreach (self::HEADER_ALIASES as $key => $aliases) {
            foreach ($aliases as $alias) {
                if (self::normalizeHeader($alias) === $normalized) {
                    return $key;
                }
            }
        }

        return null;
    }

    private static function normalizeHeader(string $value): string
    {
        $value = preg_replace('/^\xEF\xBB\xBF/', '', $value) ?? $value;
        $value = self::normalizeValue($value);

        return preg_replace('/[\s_\-]+/u', '', $value) ?? $value;
    }

    private static function normalizeValue(string $value): string
    {
        $value = str_replace(["\u{200C}", "\u{200E}", "\u{200F}"], '', $value);
        $value = str_replace(['ي', 'ك'], ['ی', 'ک'], $value);
        $value = mb_strtolower(trim($value));

        return preg_replace('/[\s_\-]+/u', '', $value) ?? $value;
    }

    private static function toUtf8(string $contents): string
    {
        if (str_starts_with($contents, "\xFF\xFE")) {
            return mb_convert_encoding(substr($contents, 2), 'UTF-8', 'UTF-16LE');
        }

        if (str_starts_with($contents, "\xFE\xFF")) {
            return mb_convert_encoding(substr($contents, 2), 'UTF-8', 'UTF-16BE');
        }

        if (mb_check_encoding($contents, 'UTF-8')) {
            return $contents;
        }

        $converted = @mb_convert_encoding($contents, 'UTF-8', 'Windows-1256');

        if ($converted === false || ! mb_check_encoding($converted, 'UTF-8')) {
            throw new RuntimeException('کدگذاری فایل پشتیبانی نمی‌شود. فایل را با کدگذاری UTF-8 ذخیره کنید.');
        }

        return $converted;
    }

    private static function detectDelimiter(string $contents): string
    {
        $firstLine = strtok($contents, "\r\n") ?: '';

        $candidates = [
            ',' => substr_count($firstLine, ','),
            ';' => substr_count($firstLine, ';'),
            "\t" => substr_count($firstLine, "\t"),
        ];

        arsort($candidates);

        return (string) array_key_first($candidates);
    }

    /**
     * @param  array<int, string|null>  $cells
     */
    private static function isEmptyRow(array $cells): bool
    {
        foreach ($cells as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }
}
