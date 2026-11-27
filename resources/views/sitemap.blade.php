<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $item)
    <url>
        <loc>{{ $item['loc'] }}</loc>
        @if (!empty($item['lastmod']))
            <lastmod>{{ $item['lastmod'] }}</lastmod>
        @endif
        <changefreq>{{ $item['changefreq'] ?? 'monthly' }}</changefreq>
        <priority>{{ $item['priority'] ?? '0.6' }}</priority>
    </url>
@endforeach
</urlset>
