
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @foreach($sitemaps as $value)
        <url>
            <loc>{{ $value }}</loc>
        </url>
    @endforeach
</urlset>
