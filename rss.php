<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/helpers.php';

$lang = resolveLang();
$htmlLang = $lang === 'en' ? 'en-us' : 'fa-ir';

/** @var array<string,string> $translations */
$translations = require __DIR__ . "/includes/i18n.$lang.php";
/** @var array<string,array{title:string,description:string,excerpt:string,date:string}> $articles */
$articles = require __DIR__ . "/includes/blog-meta.$lang.php";

$blogUrl = APP_URL . ($lang === 'en' ? '/en/blog' : '/blog');
$feedUrl = APP_URL . ($lang === 'en' ? '/en/feed' : '/feed');

header('Content-Type: application/rss+xml; charset=utf-8');

$xml = new XMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->startDocument('1.0', 'UTF-8');
$xml->startElement('rss');
$xml->writeAttribute('version', '2.0');
$xml->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');

$xml->startElement('channel');
$xml->writeElement('title', t('Blog Meta Title', $translations) . ' | ' . APP_NAME);
$xml->writeElement('link', $blogUrl);
$xml->writeElement('description', t('Blog Meta Description', $translations));
$xml->writeElement('language', $htmlLang);
$xml->writeElement('generator', APP_NAME . ' v' . APP_VERSION);
$xml->startElement('atom:link');
$xml->writeAttribute('href', $feedUrl);
$xml->writeAttribute('rel', 'self');
$xml->writeAttribute('type', 'application/rss+xml');
$xml->endElement();

foreach ($articles as $slug => $a) {
    $url = $blogUrl . '/' . $slug;
    $xml->startElement('item');
    $xml->writeElement('title', $a['title']);
    $xml->writeElement('link', $url);
    $xml->writeElement('guid', $url);
    $xml->writeElement('description', $a['description']);
    $pubDate = new DateTime($a['date'], new DateTimeZone('UTC'));
    $xml->writeElement('pubDate', $pubDate->format(DATE_RSS));
    $xml->endElement();
}

$xml->endElement(); // channel
$xml->endElement(); // rss
$xml->endDocument();

echo $xml->outputMemory();
