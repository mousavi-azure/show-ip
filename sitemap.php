<?php
declare(strict_types=1);

/**
 * Dynamic XML sitemap. Served at /sitemap.xml via the .htaccess rewrite.
 * Static pages are listed explicitly; blog articles are pulled from
 * includes/blog-meta.en.php (the canonical registry) so new articles and
 * updated dates appear automatically — no hand-editing.
 *
 * Every URL is emitted in both languages with reciprocal hreflang links
 * (fa-IR, fa, en, x-default), matching the <link rel="alternate"> tags in
 * the page <head>s.
 */

require_once __DIR__ . '/includes/config.php';

/** @var array<string,array{title:string,description:string,excerpt:string,date:string}> $articles */
$articles = require __DIR__ . '/includes/blog-meta.en.php';

$today = date('Y-m-d');

// Newest article date drives the blog index lastmod.
$lastmodOf = static fn(array $a): string => $a['modified'] ?? $a['date'];
$dates = array_filter(array_map($lastmodOf, $articles));
$blogLastmod = $dates ? max($dates) : $today;

/**
 * Each entry: [fa path, en path, lastmod, changefreq, priority]
 */
$entries = [
    ['/',     '/en',     $today,       'daily',   '1.0'],
    ['/faq',  '/en/faq', '2026-08-19', 'monthly', '0.7'],
    ['/blog', '/en/blog', $blogLastmod, 'weekly',  '0.8'],
];

foreach ($articles as $slug => $a) {
    $entries[] = ['/blog/' . $slug, '/en/blog/' . $slug, $lastmodOf($a), 'monthly', '0.6'];
}

header('Content-Type: application/xml; charset=utf-8');

$xml = new XMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->startDocument('1.0', 'UTF-8');
$xml->startElementNs(null, 'urlset', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$xml->writeAttributeNs('xmlns', 'xhtml', null, 'http://www.w3.org/1999/xhtml');

$alt = static function (XMLWriter $xml, string $hreflang, string $href): void {
    $xml->startElement('xhtml:link');
    $xml->writeAttribute('rel', 'alternate');
    $xml->writeAttribute('hreflang', $hreflang);
    $xml->writeAttribute('href', $href);
    $xml->endElement();
};

foreach ($entries as [$faPath, $enPath, $lastmod, $changefreq, $priority]) {
    $faUrl = APP_URL . $faPath;
    $enUrl = APP_URL . $enPath;

    foreach ([$faUrl, $enUrl] as $loc) {
        $xml->startElement('url');
        $xml->writeElement('loc', $loc);
        $alt($xml, 'fa-IR', $faUrl);
        $alt($xml, 'fa', $faUrl);
        $alt($xml, 'en', $enUrl);
        $alt($xml, 'x-default', $faUrl);
        $xml->writeElement('lastmod', $lastmod);
        $xml->writeElement('changefreq', $changefreq);
        $xml->writeElement('priority', $priority);
        $xml->endElement();
    }
}

$xml->endElement(); // urlset
$xml->endDocument();

echo $xml->outputMemory();
