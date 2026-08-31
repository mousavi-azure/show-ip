<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/icons.php';

http_response_code(404);

$lang = resolveLang();
$htmlLang = $lang === 'en' ? 'en' : 'fa-IR';
$htmlDir = $lang === 'en' ? 'ltr' : 'rtl';

/** @var array<string,string> $translations */
$translations = require __DIR__ . "/includes/i18n.$lang.php";

$homeUrl = $lang === 'en' ? APP_URL . '/en' : APP_URL . '/';
$blogUrl = $lang === 'en' ? APP_URL . '/en/blog' : APP_URL . '/blog';
$faqUrl  = $lang === 'en' ? APP_URL . '/en/faq' : APP_URL . '/faq';

$pageTitle = t('Page Not Found', $translations) . ' | ' . APP_NAME;
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
    <meta name="robots" content="noindex, follow">
    <meta name="theme-color" content="#4f46e5">
    <link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/assets/css/site.css">
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
        </nav>
    </div>
</header>

<main class="container">

    <div class="hero">
        <span class="hero-eyebrow"><?= icon('alert') ?> 404</span>
        <h1 class="hero-title"><?= e(t('Page Not Found', $translations)) ?></h1>
        <p class="hero-subtitle"><?= e(t('Page Not Found Body', $translations)) ?></p>
    </div>

    <div class="section-head">
        <a class="btn-calc" href="<?= e($homeUrl) ?>"><?= icon('globe') ?> <?= e(t('Back To Home CTA', $translations)) ?></a>
        <a class="btn-pill alt" href="<?= e($blogUrl) ?>"><?= icon('list') ?> <?= e(t('Blog', $translations)) ?></a>
        <a class="btn-pill alt" href="<?= e($faqUrl) ?>"><?= icon('list') ?> <?= e(t('Frequently Asked Questions', $translations)) ?></a>
    </div>

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
