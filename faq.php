<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/icons.php';

$lang = resolveLang();
$htmlLang = $lang === 'en' ? 'en' : 'fa-IR';
$htmlDir = $lang === 'en' ? 'ltr' : 'rtl';

/** @var array<string,string> $translations */
$translations = require __DIR__ . "/includes/i18n.$lang.php";
/** @var array<int,array{q:string,a:string}> $faqs */
$faqs = require __DIR__ . "/includes/faq.$lang.php";
/** @var array<string,array{title:string,description:string,excerpt:string,date:string}> $blogArticles */
$blogArticles = require __DIR__ . "/includes/blog-meta.$lang.php";
$relatedFaqSlugs = ['what-is-an-ip-address', 'how-vpn-changes-your-ip', 'private-vs-public-ip'];

$pageTitle = t('FAQ Meta Title', $translations) . ' | ' . APP_NAME;
$pageDescription = t('FAQ Meta Description', $translations);

$urlFa = APP_URL . '/faq';
$urlEn = APP_URL . '/en/faq';
$canonicalUrl = $lang === 'en' ? $urlEn : $urlFa;
$homeUrl = $lang === 'en' ? APP_URL . '/en' : APP_URL . '/';
$ogImage = APP_URL . ($lang === 'en' ? '/assets/img/og-image-en.png' : '/assets/img/og-image.png');
?><!DOCTYPE html>
<html lang="<?= e($htmlLang) ?>" dir="<?= e($htmlDir) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
    (() => {
        const saved = localStorage.getItem('theme');
        let theme = saved;
        if (!theme) {
            const hour = new Date().getHours();
            theme = (hour >= 18 || hour < 6) ? 'dark' : 'light';
        }
        if (theme === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    })();
    </script>
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="author" content="<?= e(APP_AUTHOR) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#4f46e5">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="fa-IR">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="fa">
    <link rel="alternate" href="<?= e($urlEn) ?>" hreflang="en">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="x-default">

    <meta property="og:type" content="article">
    <meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'fa_IR' ?>">
    <meta property="og:site_name" content="<?= e(APP_NAME) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="preload" href="/assets/fonts/Vazirmatn-Bold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/assets/fonts/Vazirmatn-Black.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="/assets/css/site.css">

    <script type="application/ld+json">
    <?= json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => t('Home', $translations), 'item' => $homeUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => t('Frequently Asked Questions', $translations), 'item' => $canonicalUrl],
                ],
            ],
            [
                '@type' => 'FAQPage',
                'inLanguage' => $htmlLang,
                'mainEntity' => array_map(static fn($f) => [
                    '@type' => 'Question',
                    'name'  => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ], $faqs),
            ],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
    </script>
</head>

<body>

<header class="site-header">
    <div class="container">
        <a class="brand" href="<?= e($homeUrl) ?>">
            <img src="/assets/img/logo.svg" width="42" height="42" alt="<?= e(sprintf(t('Logo Alt', $translations), APP_NAME)) ?>">
            <div>
                <div class="brand-title"><?= e(APP_NAME) ?></div>
                <div class="brand-subtitle"><?= e(t('Brand Subtitle', $translations)) ?></div>
            </div>
        </a>
        <nav class="header-actions">
            <a class="btn-pill alt" href="<?= e($homeUrl) ?>"><?= icon('globe') ?> <?= e(t('Show My IP Nav', $translations)) ?></a>
            <a class="btn-pill" href="<?= e($homeUrl) ?>#calculator"><?= icon('calculator') ?> <?= e(t('Tools & Calculator', $translations)) ?></a>
            <a class="btn-pill" href="<?= $lang === 'en' ? '/en/blog' : '/blog' ?>"><?= icon('list') ?> <?= e(t('Blog', $translations)) ?></a>
            <?php if ($lang === 'en'): ?>
                <a class="btn-pill lang-switch" href="/faq" hreflang="fa-IR" lang="fa" dir="rtl">فارسی</a>
            <?php else: ?>
                <a class="btn-pill lang-switch" href="/en/faq" hreflang="en" lang="en" dir="ltr">English</a>
            <?php endif; ?>
            <button type="button" class="theme-toggle" id="themeToggle" title="<?= e(t('Toggle theme', $translations)) ?>" aria-label="<?= e(t('Toggle theme', $translations)) ?>">
                <?= icon('moon', 'ic ic-moon') ?><?= icon('sun', 'ic ic-sun') ?>
            </button>
        </nav>
    </div>
</header>

<main class="container">

    <div class="hero">
        <span class="hero-eyebrow"><?= icon('list') ?> <?= e(t('Guide', $translations)) ?></span>
        <h1 class="hero-title"><?= e(t('Frequently Asked Questions', $translations)) ?></h1>
        <p class="hero-subtitle"><?= e($pageDescription) ?></p>
    </div>

    <section aria-label="<?= e(t('FAQ Section Aria', $translations)) ?>">
        <div class="faq-list">
            <?php foreach ($faqs as $i => $f): ?>
            <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
                <summary class="faq-q"><span class="num"><?= $i + 1 ?>.</span> <span><?= e($f['q']) ?></span> <?= icon('chevron') ?></summary>
                <div class="faq-a"><?= e($f['a']) ?></div>
            </details>
            <?php endforeach; ?>
        </div>

        <div class="section-head">
            <a class="btn-calc" href="<?= e($homeUrl) ?>"><?= icon('globe') ?> <?= e(t('Back To Home CTA', $translations)) ?></a>
        </div>
    </section>

    <section class="section-head-left" aria-label="<?= e(t('Related Articles', $translations)) ?>">
        <h2 class="related-heading"><?= icon('list') ?> <?= e(t('Related Articles', $translations)) ?></h2>
        <div class="blog-grid">
            <?php $blogBase = $lang === 'en' ? '/en/blog' : '/blog'; ?>
            <?php foreach ($relatedFaqSlugs as $s): $a = $blogArticles[$s]; ?>
            <a class="blog-card" href="<?= e($blogBase . '/' . $s) ?>">
                <h3 class="blog-card-title"><?= e($a['title']) ?></h3>
                <p class="blog-card-excerpt"><?= e($a['excerpt']) ?></p>
                <span class="blog-card-link"><?= e(t('Read Article', $translations)) ?> <?= icon('external') ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="footer">
        <p class="footer-credit">
            <?= e(t('Footer Credit Prefix', $translations)) ?> <?= icon('heart') ?> <?= e(t('Footer Credit Suffix', $translations)) ?>
            <a href="<?= e(APP_AUTHOR_URL) ?>" target="_blank" rel="noopener noreferrer"><?= e(APP_AUTHOR) ?></a>
            — <a href="<?= e(APP_AUTHOR_URL) ?>" target="_blank" rel="noopener noreferrer">mousavi.dev</a>
        </p>
        <p class="footer-meta">© <?= date('Y') ?> <a href="<?= e($homeUrl) ?>"><?= e(APP_NAME) ?></a> — <?= e(t('All Rights Reserved', $translations)) ?> · <span class="footer-version">v<?= e(APP_VERSION) ?></span></p>
    </footer>

</main>

<script src="/assets/js/site.js" defer></script>
</body>
</html>
