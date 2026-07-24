<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/icons.php';
require_once __DIR__ . '/includes/ipdata.php';

$lang = resolveLang();
$htmlLang = $lang === 'en' ? 'en' : 'fa-IR';
$htmlDir = $lang === 'en' ? 'ltr' : 'rtl';

/** @var array<string,string> $translations */
$translations = require __DIR__ . "/includes/i18n.$lang.php";
/** @var array<int,array{q:string,a:string}> $faqs */
$faqs = require __DIR__ . "/includes/faq.$lang.php";

$pageTitle = t('Home Meta Title', $translations) . ' | ' . APP_NAME;
$pageDescription = t('Home Meta Description', $translations);

$userIP = getClientIp();
// For local development override: $userIP = '8.8.8.8';

/* ───────── CLI / API mode (e.g. `curl show-ip.ir`) ─────────
   - curl/wget/scripts            -> plain-text IP (no API call, instant)
   - ?format=text  or  /ip        -> plain-text IP
   - ?format=json  or  /json      -> full JSON details                       */
$format = strtolower((string)($_GET['format'] ?? ''));
if ($format === '' && isConsoleClient()) {
    $format = 'text';
}
if ($format === 'text' || $format === 'ip' || $format === 'plain') {
    header('Content-Type: text/plain; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    echo $userIP . "\n";
    exit;
}
if ($format === 'json') {
    $apiData = fetchIpData($userIP, IPDATA_API_KEY, IPDATA_VERIFY_SSL, IPDATA_TIMEOUT);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($apiData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit;
}

$ipData = fetchIpData($userIP, IPDATA_API_KEY, IPDATA_VERIFY_SSL, IPDATA_TIMEOUT);
$hasError = isset($ipData['error']) || isset($ipData['message']);

$urlFa = APP_URL . '/';
$urlEn = APP_URL . '/en';
$canonicalUrl = $lang === 'en' ? $urlEn : $urlFa;
$ogImage = APP_URL . ($lang === 'en' ? '/assets/img/og-image-en.png' : '/assets/img/og-image.png');

// --- Local map marker position (plotted on the self-hosted world map, no external tile server) ---
$lat = is_numeric($ipData['latitude'] ?? null) ? (float)$ipData['latitude'] : null;
$lng = is_numeric($ipData['longitude'] ?? null) ? (float)$ipData['longitude'] : null;
$osmLink = null;
$mapLeftPct = $mapTopPct = null;
if ($lat !== null && $lng !== null) {
    $mapLeftPct = round((($lng + 180) / 360) * 100, 3);
    $mapTopPct = round(((90 - $lat) / 180) * 100, 3);
    $osmLink = 'https://www.openstreetmap.org/?mlat=' . urlencode((string)$lat)
        . '&mlon=' . urlencode((string)$lng) . "#map=12/$lat/$lng";
}

// --- Threat summary ---
$threatList = [
    ['Is Tor', ($ipData['threat']['is_tor'] ?? null) === true, 'shield'],
    ['Is Proxy', ($ipData['threat']['is_proxy'] ?? null) === true, 'server'],
    ['Is VPN / Datacenter', ($ipData['threat']['is_datacenter'] ?? null) === true, 'cloud'],
    ['Is iCloud Relay', ($ipData['threat']['is_icloud_relay'] ?? null) === true, 'cloud'],
    ['Is Anonymous', ($ipData['threat']['is_anonymous'] ?? null) === true, 'lock'],
    ['Is Known Attacker', ($ipData['threat']['is_known_attacker'] ?? null) === true, 'alert'],
    ['Is Known Abuser', ($ipData['threat']['is_known_abuser'] ?? null) === true, 'alert'],
    ['Is Threat', ($ipData['threat']['is_threat'] ?? null) === true, 'shield'],
];
$flaggedCount = 0;
foreach ($threatList as $tl) { if ($tl[1]) { $flaggedCount++; } }
$isClean = !$hasError && $flaggedCount === 0;

$emojiFlag = (string)($ipData['emoji_flag'] ?? '');
$lang0 = $ipData['languages'][0] ?? null;

// --- Small translation subset exposed to client-side JS ---
$jsI18nKeys = [
    'Geolocation Not Supported', 'Locating', 'Accuracy Message', 'Permission Denied',
    'Position Unavailable', 'Position Timeout', 'Location Error', 'Precise Location Title',
    'IP Copied', 'Copied', 'Calc Missing Fields', 'Calc Generic Error', 'Calc Invalid Response',
    'Calc Network Address', 'Calc Broadcast Address', 'Calc First Usable', 'Calc Last Usable',
    'Calc Subnet Mask', 'Calc CIDR', 'Calc Total Addresses', 'Calc Usable Hosts', 'Calc Host Bits',
    'Calculating',
];
$jsI18n = [];
foreach ($jsI18nKeys as $k) { $jsI18n[$k] = t($k, $translations); }
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
    <meta name="keywords" content="<?= e(t('Home Meta Keywords', $translations)) ?>">
    <meta name="author" content="<?= e(APP_AUTHOR) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#4f46e5">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="fa-IR">
    <link rel="alternate" href="<?= e($urlEn) ?>" hreflang="en">
    <link rel="alternate" href="<?= e($urlFa) ?>" hreflang="x-default">

    <!-- Open Graph / Twitter -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'fa_IR' ?>">
    <meta property="og:site_name" content="<?= e(APP_NAME) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?= e(sprintf(t('Logo Alt', $translations), APP_NAME)) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($pageDescription) ?>">
    <meta name="twitter:image" content="<?= e($ogImage) ?>">

    <link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Preload local font for faster first paint -->
    <link rel="preload" href="/assets/fonts/Vazirmatn-Bold.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Self-hosted CSS (no external libraries) -->
    <link rel="stylesheet" href="/assets/css/site.css">

    <!-- Structured data: WebApplication + breadcrumbs + FAQ -->
    <script type="application/ld+json">
    <?= json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                'name'  => APP_NAME,
                'url'   => $canonicalUrl,
                'inLanguage' => $htmlLang,
                'publisher' => ['@type' => 'Person', 'name' => APP_AUTHOR, 'url' => APP_AUTHOR_URL],
            ],
            [
                '@type' => 'WebApplication',
                'name'  => APP_NAME,
                'url'   => $canonicalUrl,
                'softwareVersion' => APP_VERSION,
                'applicationCategory' => 'UtilityApplication',
                'operatingSystem' => 'Web',
                'description' => $pageDescription,
                'inLanguage' => $htmlLang,
                'author' => ['@type' => 'Person', 'name' => APP_AUTHOR, 'url' => APP_AUTHOR_URL],
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'IRR'],
            ],
            [
                '@type' => 'FAQPage',
                'url'   => $lang === 'en' ? APP_URL . '/en/faq' : APP_URL . '/faq',
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

<!-- ─────────────── HEADER ─────────────── -->
<header class="site-header">
    <div class="container">
        <a class="brand" href="<?= $lang === 'en' ? '/en' : '/' ?>">
            <img src="/assets/img/logo.svg" width="42" height="42" alt="<?= e(sprintf(t('Logo Alt', $translations), APP_NAME)) ?>">
            <div>
                <div class="brand-title"><?= e(APP_NAME) ?></div>
                <div class="brand-subtitle"><?= e(t('Brand Subtitle', $translations)) ?></div>
            </div>
        </a>
        <nav class="header-actions">
            <a class="btn-pill" href="#calculator"><?= icon('calculator') ?> <?= e(t('Tools & Calculator', $translations)) ?></a>
            <a class="btn-pill alt" href="#faq"><?= icon('list') ?> <?= e(t('Frequently Asked Questions', $translations)) ?></a>
            <?php if ($lang === 'en'): ?>
                <a class="btn-pill lang-switch" href="/" hreflang="fa-IR" lang="fa" dir="rtl">فارسی</a>
            <?php else: ?>
                <a class="btn-pill lang-switch" href="/en" hreflang="en" lang="en" dir="ltr">English</a>
            <?php endif; ?>
            <button type="button" class="theme-toggle" id="themeToggle" title="<?= e(t('Toggle theme', $translations)) ?>" aria-label="<?= e(t('Toggle theme', $translations)) ?>">
                <?= icon('moon', 'ic ic-moon') ?><?= icon('sun', 'ic ic-sun') ?>
            </button>
        </nav>
    </div>
</header>

<main class="container">

    <!-- ─────────────── HERO ─────────────── -->
    <div class="hero">
        <span class="hero-eyebrow"><span class="dot"></span> <?= e(APP_NAME) ?> — <?= e(t('Site Status Live', $translations)) ?></span>
        <h1 class="hero-title"><?= icon('globe') ?> <?= e(t('Hero Heading', $translations)) ?> <span class="grad"><?= e(t('IP Details Lookup', $translations)) ?></span></h1>
        <p class="hero-subtitle"><?= e($pageDescription) ?></p>
    </div>

    <?php if ($hasError): ?>
        <div class="alert alert-danger" role="alert">
            <?= icon('alert') ?>
            <span><strong><?= e(t('Error Label', $translations)) ?>:</strong>
            <?= e((string)($ipData['message'] ?? $ipData['error'] ?? t('Service temporarily unavailable', $translations))) ?></span>
        </div>
        <?php if (IPDATA_API_KEY === ''): ?>
            <div class="alert alert-warning" role="alert">
                <?= icon('info') ?>
                <span><strong><?= e(t('Note', $translations)) ?>:</strong> <?= sprintf(e(t('Env Key Missing Note', $translations)), '<code>.env</code>') ?></span>
            </div>
        <?php endif; ?>
    <?php else: ?>

        <!-- ─────────────── IP BADGE ─────────────── -->
        <section class="ip-section" aria-label="<?= e(t('IP Section Aria', $translations)) ?>">
            <div class="ip-badge">
                <div class="ip-badge-icon"><?= icon('network') ?></div>
                <div>
                    <div class="ip-badge-label"><?= e(t('Your public IP address', $translations)) ?></div>
                    <div class="ip-badge-value">
                        <?php if ($emojiFlag !== ''): ?><span class="ip-flag" aria-hidden="true"><?= $emojiFlag ?></span> <?php endif; ?>
                        <?= e($userIP) ?>
                    </div>
                </div>
                <button class="ip-copy-btn" id="copyIpBtn" data-ip="<?= e($userIP) ?>" title="<?= e(t('Copy', $translations)) ?>" aria-label="<?= e(t('Copy', $translations)) ?>">
                    <?= icon('copy') ?>
                </button>
            </div>
        </section>

        <div class="grid grid-2" id="details">

            <!-- ─── LOCATION ─── -->
            <div class="card">
                <div class="card-header"><?= icon('pin') ?> <?= e(t('Location Information', $translations)) ?></div>
                <div class="card-body">
                    <ul class="info-list">
                        <li><span class="info-label"><?= icon('flag') ?> <?= e(t('Country', $translations)) ?></span>
                            <span class="info-value"><?= $emojiFlag ?> <?= e((string)($ipData['country_name'] ?? t('N/A', $translations))) ?> <?= e((string)($ipData['country_code'] ?? '')) ?></span></li>
                        <li><span class="info-label"><?= icon('compass') ?> <?= e(t('Continent', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['continent_name'] ?? t('N/A', $translations))) ?></span></li>
                        <li><span class="info-label"><?= icon('map') ?> <?= e(t('Region', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['region'] ?? t('N/A', $translations))) ?></span></li>
                        <li><span class="info-label"><?= icon('building') ?> <?= e(t('City', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['city'] ?? t('N/A', $translations))) ?></span></li>
                        <li><span class="info-label"><?= icon('mail') ?> <?= e(t('Postal Code', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['postal'] ?? t('N/A', $translations))) ?></span></li>
                        <li><span class="info-label"><?= icon('phone') ?> <?= e(t('Calling Code', $translations)) ?></span>
                            <span class="info-value">+<?= e((string)($ipData['calling_code'] ?? '—')) ?></span></li>
                        <li><span class="info-label"><?= icon('crosshair') ?> <?= e(t('Coordinates', $translations)) ?></span>
                            <span class="info-value"><?= e(($lat !== null && $lng !== null) ? "$lat, $lng" : t('N/A', $translations)) ?></span></li>
                    </ul>

                    <div class="map-shell">
                        <div class="map-widget" id="mapWidget" data-ip-lat="<?= e((string)($lat ?? '')) ?>" data-ip-lng="<?= e((string)($lng ?? '')) ?>">
                            <img class="map-img" src="/assets/img/world-map.svg" alt="<?= e(t('Map Alt', $translations)) ?>" loading="lazy" width="940" height="477">
                            <div class="map-graticule" aria-hidden="true"></div>
                            <?php if ($mapLeftPct !== null): ?>
                            <button type="button" class="map-marker map-marker-ip" id="ipMarker"
                                    style="left:<?= $mapLeftPct ?>%;top:<?= $mapTopPct ?>%"
                                    title="<?= e(t('IP-based location', $translations)) ?>: <?= e((string)($ipData['city'] ?? '')) ?>">
                                <?= icon('pin') ?>
                            </button>
                            <?php endif; ?>
                            <button type="button" class="map-marker map-marker-gps" id="gpsMarker" hidden title="<?= e(t('Your precise location', $translations)) ?>">
                                <span class="pulse" aria-hidden="true"></span><?= icon('crosshair-gps') ?>
                            </button>
                        </div>
                        <div class="map-legend">
                            <?php if ($mapLeftPct !== null): ?>
                            <span class="map-legend-item"><span class="map-legend-swatch ip"></span> <?= e(t('IP-based location', $translations)) ?></span>
                            <?php endif; ?>
                            <span class="map-legend-item" id="gpsLegend" hidden><span class="map-legend-swatch gps"></span> <?= e(t('Your precise location', $translations)) ?></span>
                        </div>
                    </div>
                    <div class="map-actions">
                        <button type="button" class="btn-pill" id="geoBtn">
                            <?= icon('crosshair-gps') ?> <?= e(t('Use my precise location', $translations)) ?>
                        </button>
                        <?php if ($osmLink !== null): ?>
                            <a class="btn-pill alt" href="<?= e($osmLink) ?>" target="_blank" rel="noopener">
                                <?= icon('external') ?> <?= e(t('Open in OpenStreetMap', $translations)) ?>
                            </a>
                        <?php endif; ?>
                        <span class="geo-status" id="geoStatus" hidden></span>
                    </div>
                    <p style="color:var(--text-muted);font-size:.76rem;margin-top:10px;line-height:1.8;">
                        <?= icon('info') ?> <?= e(t('Map is self-hosted; nothing is loaded from external map servers. Precise location uses your browser only and is never sent anywhere.', $translations)) ?>
                    </p>
                </div>
            </div>

            <!-- ─── NETWORK & SECURITY ─── -->
            <div class="card">
                <div class="card-header"><?= icon('network') ?> <?= e(t('Network Information', $translations)) ?></div>
                <div class="card-body">
                    <ul class="info-list">
                        <li><span class="info-label"><?= icon('building') ?> <?= e(t('ISP', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['asn']['name'] ?? t('N/A', $translations))) ?></span></li>
                        <li><span class="info-label"><?= icon('branch') ?> <?= e(t('ASN', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['asn']['asn'] ?? t('N/A', $translations))) ?></span></li>
                        <li><span class="info-label"><?= icon('share') ?> <?= e(t('Organization', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['asn']['domain'] ?? t('N/A', $translations))) ?></span></li>
                        <li><span class="info-label"><?= icon('server') ?> <?= e(t('Route', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['asn']['route'] ?? t('N/A', $translations))) ?></span></li>
                        <?php if (!empty($ipData['carrier']['name'])): ?>
                        <li><span class="info-label"><?= icon('sim') ?> <?= e(t('Carrier', $translations)) ?></span>
                            <span class="info-value"><?= e((string)$ipData['carrier']['name']) ?></span></li>
                        <?php endif; ?>
                        <li><span class="info-label"><?= icon('clock') ?> <?= e(t('Time Zone', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['time_zone']['name'] ?? t('N/A', $translations))) ?></span></li>
                        <?php if (!empty($ipData['time_zone']['current_time'])): ?>
                        <li><span class="info-label"><?= icon('sun') ?> <?= e(t('Local Time', $translations)) ?></span>
                            <span class="info-value" id="localTime" data-time="<?= e((string)$ipData['time_zone']['current_time']) ?>"><?= e(date('H:i:s', strtotime((string)$ipData['time_zone']['current_time']))) ?></span></li>
                        <?php endif; ?>
                        <?php if ($lang0): ?>
                        <li><span class="info-label"><?= icon('languages') ?> <?= e(t('Language', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($lang0['native'] ?? $lang0['name'] ?? '')) ?></span></li>
                        <?php endif; ?>
                        <li><span class="info-label"><?= icon('coins') ?> <?= e(t('Currency', $translations)) ?></span>
                            <span class="info-value"><?= e((string)($ipData['currency']['name'] ?? t('N/A', $translations))) ?> <?= e((string)($ipData['currency']['symbol'] ?? '')) ?></span></li>
                    </ul>

                    <div class="section-sep">
                        <div class="section-sep-line"></div>
                        <div class="section-sep-label"><?= icon('shield') ?> <?= e(t('Threat Information', $translations)) ?></div>
                        <div class="section-sep-line"></div>
                    </div>

                    <div class="sec-summary <?= $isClean ? 'clean' : 'flagged' ?>">
                        <?= $isClean ? icon('check') : icon('alert') ?>
                        <span><?= e(t('Security Status', $translations)) ?>:
                        <?= $isClean ? e(t('Clean', $translations)) : e(t('Flagged', $translations)) . ' (' . $flaggedCount . ')' ?></span>
                    </div>

                    <div class="threat-grid">
                        <?php foreach ($threatList as [$label, $isDanger, $ic]): ?>
                        <div class="threat-item">
                            <div class="threat-dot <?= $isDanger ? 'danger' : 'safe' ?>"></div>
                            <div class="threat-info">
                                <div class="threat-text"><?= e(t($label, $translations)) ?></div>
                                <div class="threat-status <?= $isDanger ? 'danger' : 'safe' ?>"><?= $isDanger ? e(t('Yes', $translations)) : e(t('No', $translations)) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="raw-details">
                        <details>
                            <summary class="raw-toggle"><?= icon('code') ?> <?= e(t('Raw API Response', $translations)) ?></summary>
                            <pre class="raw-json"><?= e(json_encode($ipData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?></pre>
                        </details>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <!-- ─────────────── CALCULATOR ─────────────── -->
    <section class="card calc-card" id="calculator" aria-label="<?= e(t('Calculator Section Aria', $translations)) ?>">
        <div class="card-header"><?= icon('calculator') ?> <?= e(t('Network Calculator', $translations)) ?></div>
        <div class="card-body">
            <form id="ipCalcForm" novalidate>
                <div class="form-row">
                    <div>
                        <label for="ipAddress" class="form-label"><?= e(t('IP Address', $translations)) ?></label>
                        <input type="text" class="form-control" id="ipAddress" placeholder="<?= e(t('IP Placeholder', $translations)) ?>" autocomplete="off" inputmode="decimal">
                    </div>
                    <div>
                        <label for="subnet" class="form-label"><?= e(t('Subnet Mask or CIDR', $translations)) ?></label>
                        <input type="text" class="form-control" id="subnet" placeholder="<?= e(t('Subnet Placeholder', $translations)) ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-calc"><?= icon('zap') ?> <?= e(t('Calculate', $translations)) ?></button>
                </div>
            </form>
            <div id="ipCalcResult" class="mt-3" aria-live="polite"></div>
        </div>
    </section>

    <!-- ─────────────── CLI / TERMINAL ─────────────── -->
    <section class="card cli-card" id="cli" aria-label="<?= e(t('CLI Aria', $translations)) ?>">
        <div class="card-header"><?= icon('code') ?> <?= e(t('CLI Heading', $translations)) ?></div>
        <div class="card-body">
            <p style="color:var(--text-secondary);font-size:.9rem;margin-bottom:14px;line-height:1.9;">
                <?= sprintf(e(t('CLI Description', $translations)), '<code>ifconfig.me</code>') ?>
            </p>
            <div class="term">
                <div class="term-bar"><span></span><span></span><span></span></div>
                <?php
                $host = preg_replace('~^https?://~', '', APP_URL);
                $cmds = [
                    ['curl ' . $host,          t('CLI Desc Plain', $translations)],
                    ['curl ' . $host . '/ip',   t('CLI Desc IP', $translations)],
                    ['curl ' . $host . '/json', t('CLI Desc JSON', $translations)],
                ];
                foreach ($cmds as [$cmd, $desc]): ?>
                <div class="term-line">
                    <code class="term-cmd" data-copy="<?= e($cmd) ?>"><span class="term-prompt">$</span> <?= e($cmd) ?></code>
                    <button class="term-copy" type="button" data-copy="<?= e($cmd) ?>" title="<?= e(t('Copy', $translations)) ?>" aria-label="<?= e(t('Copy', $translations)) ?>"><?= icon('copy') ?></button>
                    <span class="term-desc"><?= e($desc) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ─────────────── FAQ ─────────────── -->
    <section id="faq" aria-label="<?= e(t('FAQ Section Aria', $translations)) ?>">
        <div class="section-head">
            <h2><?= icon('list') ?> <?= e(t('Frequently Asked Questions', $translations)) ?></h2>
            <p><?= e(t('FAQ Teaser Subtitle', $translations)) ?></p>
        </div>
        <div class="faq-list">
            <?php foreach ($faqs as $i => $f): ?>
            <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
                <summary class="faq-q"><span class="num"><?= $i + 1 ?>.</span> <span><?= e($f['q']) ?></span> <?= icon('chevron') ?></summary>
                <div class="faq-a"><?= e($f['a']) ?></div>
            </details>
            <?php endforeach; ?>
        </div>
        <div class="section-head">
            <a class="btn-pill alt" href="<?= $lang === 'en' ? '/en/faq' : '/faq' ?>"><?= icon('list') ?> <?= e(t('View All FAQ', $translations)) ?></a>
        </div>
    </section>

    <!-- ─────────────── FOOTER ─────────────── -->
    <footer class="footer">
        <p class="footer-credit">
            <?= e(t('Footer Credit Prefix', $translations)) ?> <?= icon('heart') ?> <?= e(t('Footer Credit Suffix', $translations)) ?>
            <a href="<?= e(APP_AUTHOR_URL) ?>" target="_blank" rel="noopener noreferrer"><?= e(APP_AUTHOR) ?></a>
            — <a href="<?= e(APP_AUTHOR_URL) ?>" target="_blank" rel="noopener noreferrer">mousavi.dev</a>
        </p>
        <p class="footer-meta">© <?= date('Y') ?> <a href="<?= e($canonicalUrl) ?>"><?= e(APP_NAME) ?></a> — <?= e(t('All Rights Reserved', $translations)) ?> · <span class="footer-version">v<?= e(APP_VERSION) ?></span></p>
    </footer>

</main>

<script>
window.APP_LANG = <?= json_encode($lang) ?>;
window.APP_I18N = <?= json_encode($jsI18n, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
<script src="/assets/js/site.js" defer></script>
</body>
</html>
