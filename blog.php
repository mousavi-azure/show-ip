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
/** @var array<string,array{title:string,description:string,excerpt:string,date:string}> $articles */
$articles = require __DIR__ . "/includes/blog-meta.$lang.php";

$slugsInOrder = array_keys($articles);
$slug = resolveBlogSlug();
$article = ($slug !== null && isset($articles[$slug])) ? $articles[$slug] : null;

$blogUrlFa = APP_URL . '/blog';
$blogUrlEn = APP_URL . '/en/blog';
$blogUrl = $lang === 'en' ? $blogUrlEn : $blogUrlFa;
$homeUrl = $lang === 'en' ? APP_URL . '/en' : APP_URL . '/';
$ogImage = APP_URL . ($lang === 'en' ? '/assets/img/og-image-en.png' : '/assets/img/og-image.png');

$notFound = ($slug !== null && $article === null);
if ($notFound) {
    http_response_code(404);
}

if ($article !== null) {
    $pageTitle = $article['title'] . ' | ' . APP_NAME;
    $pageDescription = $article['description'];
    $urlFa = APP_URL . '/blog/' . $slug;
    $urlEn = APP_URL . '/en/blog/' . $slug;
} else {
    $pageTitle = t('Blog Meta Title', $translations) . ' | ' . APP_NAME;
    $pageDescription = t('Blog Meta Description', $translations);
    $urlFa = $blogUrlFa;
    $urlEn = $blogUrlEn;
}
$canonicalUrl = $lang === 'en' ? $urlEn : $urlFa;

$bodyHtml = null;
if ($article !== null) {
    $bodyHtml = require __DIR__ . "/includes/blog/$slug.$lang.php";
}

// Up to 3 related articles (next ones in registry order, wrapping around).
$relatedSlugs = [];
if ($slug !== null && $article !== null) {
    $idx = array_search($slug, $slugsInOrder, true);
    $count = count($slugsInOrder);
    for ($i = 1; $i <= $count - 1 && count($relatedSlugs) < 3; $i++) {
        $relatedSlugs[] = $slugsInOrder[($idx + $i) % $count];
    }
}
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
    <meta name="robots" content="<?= $notFound ? 'noindex, follow' : 'index, follow, max-image-preview:large' ?>">
    <meta name="theme-color" content="#4f46e5">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="fa-IR">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="fa">
    <link rel="alternate" href="<?= e($urlEn) ?>" hreflang="en">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="x-default">
    <link rel="alternate" type="application/rss+xml" title="<?= e(APP_NAME) ?> Blog" href="<?= e(APP_URL . ($lang === 'en' ? '/en/feed' : '/feed')) ?>">

    <meta property="og:type" content="<?= $article !== null ? 'article' : 'website' ?>">
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

    <?php if (!$notFound): ?>
    <script type="application/ld+json">
    <?php
    $breadcrumbItems = [
        ['@type' => 'ListItem', 'position' => 1, 'name' => t('Home', $translations), 'item' => $homeUrl],
        ['@type' => 'ListItem', 'position' => 2, 'name' => t('Blog', $translations), 'item' => $blogUrl],
    ];
    if ($article !== null) {
        $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $article['title'], 'item' => $canonicalUrl];
    }
    $graph = [
        ['@type' => 'BreadcrumbList', 'itemListElement' => $breadcrumbItems],
    ];
    if ($article !== null) {
        $graph[] = [
            '@type' => 'Article',
            'headline' => $article['title'],
            'description' => $article['description'],
            'datePublished' => $article['date'],
            'dateModified' => $article['date'],
            'inLanguage' => $htmlLang,
            'url' => $canonicalUrl,
            'author' => ['@type' => 'Person', 'name' => APP_AUTHOR, 'url' => APP_AUTHOR_URL],
            'publisher' => [
                '@type' => 'Organization',
                'name' => APP_NAME,
                'logo' => ['@type' => 'ImageObject', 'url' => APP_URL . '/assets/img/logo.svg'],
            ],
            'image' => $ogImage,
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonicalUrl],
        ];
    } else {
        $graph[] = [
            '@type' => 'CollectionPage',
            'name' => t('Blog Meta Title', $translations),
            'description' => $pageDescription,
            'url' => $canonicalUrl,
            'inLanguage' => $htmlLang,
        ];
    }
    echo json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    ?>
    </script>
    <?php endif; ?>
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
            <a class="btn-pill" href="<?= e($blogUrl) ?>"><?= icon('list') ?> <?= e(t('Blog', $translations)) ?></a>
            <?php if ($lang === 'en'): ?>
                <a class="btn-pill lang-switch" href="<?= e($urlFa) ?>" hreflang="fa-IR" lang="fa" dir="rtl">فارسی</a>
            <?php else: ?>
                <a class="btn-pill lang-switch" href="<?= e($urlEn) ?>" hreflang="en" lang="en" dir="ltr">English</a>
            <?php endif; ?>
            <button type="button" class="theme-toggle" id="themeToggle" title="<?= e(t('Toggle theme', $translations)) ?>" aria-label="<?= e(t('Toggle theme', $translations)) ?>">
                <?= icon('moon', 'ic ic-moon') ?><?= icon('sun', 'ic ic-sun') ?>
            </button>
        </nav>
    </div>
</header>

<main class="container">

    <?php if ($notFound): ?>

        <div class="hero">
            <span class="hero-eyebrow"><?= icon('list') ?> <?= e(t('Blog', $translations)) ?></span>
            <h1 class="hero-title"><?= e(t('Article Not Found', $translations)) ?></h1>
            <p class="hero-subtitle"><?= e(t('Article Not Found Body', $translations)) ?></p>
        </div>
        <div class="section-head">
            <a class="btn-calc" href="<?= e($blogUrl) ?>"><?= icon('list') ?> <?= e(t('Back to Articles', $translations)) ?></a>
        </div>

    <?php elseif ($article !== null): ?>

        <nav class="article-breadcrumb" aria-label="breadcrumb">
            <a href="<?= e($homeUrl) ?>"><?= e(t('Home', $translations)) ?></a>
            <span>/</span>
            <a href="<?= e($blogUrl) ?>"><?= e(t('Blog', $translations)) ?></a>
        </nav>

        <div class="hero article-hero">
            <h1 class="hero-title"><?= e($article['title']) ?></h1>
            <p class="article-meta"><?= icon('clock') ?> <?= e(t('Published', $translations)) ?>: <time datetime="<?= e($article['date']) ?>"><?= e($article['date']) ?></time></p>
        </div>

        <article class="card article-card">
            <div class="card-body article-prose">
                <?= $bodyHtml ?>
            </div>
        </article>

        <div class="card cta-card">
            <div class="card-body cta-card-body">
                <div class="cta-icon"><?= icon('network') ?></div>
                <div>
                    <div class="cta-title"><?= e(APP_NAME) ?></div>
                    <div class="cta-text"><?= e(t('Home Meta Description', $translations)) ?></div>
                </div>
                <a class="btn-calc" href="<?= e($homeUrl) ?>"><?= icon('zap') ?> <?= e(t('Try The Tool', $translations)) ?></a>
            </div>
        </div>

        <?php if (!empty($relatedSlugs)): ?>
        <section class="section-head-left" aria-label="<?= e(t('Related Articles', $translations)) ?>">
            <h2 class="related-heading"><?= icon('list') ?> <?= e(t('Related Articles', $translations)) ?></h2>
            <div class="blog-grid">
                <?php foreach ($relatedSlugs as $rs): $ra = $articles[$rs]; ?>
                <a class="blog-card" href="<?= e($blogUrl . '/' . $rs) ?>">
                    <h3 class="blog-card-title"><?= e($ra['title']) ?></h3>
                    <p class="blog-card-excerpt"><?= e($ra['excerpt']) ?></p>
                    <span class="blog-card-link"><?= e(t('Read Article', $translations)) ?> <?= icon('external') ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <div class="section-head">
            <a class="btn-pill alt" href="<?= e($blogUrl) ?>"><?= icon('list') ?> <?= e(t('Back to Articles', $translations)) ?></a>
        </div>

    <?php else: ?>

        <div class="hero">
            <span class="hero-eyebrow"><?= icon('list') ?> <?= e(APP_NAME) ?></span>
            <h1 class="hero-title"><?= e(t('All Articles', $translations)) ?></h1>
            <p class="hero-subtitle"><?= e(t('Blog Intro', $translations)) ?></p>
        </div>

        <div class="blog-grid">
            <?php foreach ($articles as $s => $a): ?>
            <a class="blog-card" href="<?= e($blogUrl . '/' . $s) ?>">
                <h2 class="blog-card-title"><?= e($a['title']) ?></h2>
                <p class="blog-card-excerpt"><?= e($a['excerpt']) ?></p>
                <span class="blog-card-link"><?= e(t('Read Article', $translations)) ?> <?= icon('external') ?></span>
            </a>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

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
