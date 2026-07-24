<?php
declare(strict_types=1);

/**
 * Escape HTML safely.
 */
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Best-effort client IP detection (supports reverse proxies/CDNs).
 * NOTE: If you are behind a proxy, set trusted headers on the server side.
 */
function getClientIp(): string {
    $candidates = [];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // may contain multiple IPs. use first valid public IP.
        $parts = array_map('trim', explode(',', (string)$_SERVER['HTTP_X_FORWARDED_FOR']));
        $candidates = array_merge($candidates, $parts);
    }

    if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $candidates[] = (string)$_SERVER['HTTP_X_REAL_IP'];
    }

    if (!empty($_SERVER['REMOTE_ADDR'])) {
        $candidates[] = (string)$_SERVER['REMOTE_ADDR'];
    }

    foreach ($candidates as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $ip;
        }
    }

    // fallback: allow private IPs if no public IP is detected
    foreach ($candidates as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }

    return '0.0.0.0';
}

/**
 * Detect command-line / script HTTP clients (curl, wget, etc.) so we can
 * answer them with a plain-text IP instead of the full HTML page.
 * SEO crawlers (Googlebot, Bingbot…) are intentionally excluded -> they get HTML.
 */
function isConsoleClient(): bool {
    $ua = strtolower((string)($_SERVER['HTTP_USER_AGENT'] ?? ''));
    if ($ua === '') {
        return true; // no User-Agent => almost always a script
    }
    // Never treat known web/search crawlers as console clients.
    foreach (['bot', 'spider', 'crawl', 'slurp', 'facebookexternalhit', 'embedly'] as $bot) {
        if (str_contains($ua, $bot)) {
            return false;
        }
    }
    foreach (['curl', 'wget', 'httpie', 'python-requests', 'go-http', 'libwww',
              'powershell', 'lwp', 'okhttp', 'java/', 'ruby', 'axios', 'got ('] as $tool) {
        if (str_contains($ua, $tool)) {
            return true;
        }
    }
    return false;
}

/**
 * Translation helper.
 * @param array<string,string> $translations
 */
function t(string $text, array $translations): string {
    return $translations[$text] ?? $text;
}

/**
 * Resolve the active UI language. Prefers the `lang` query param (set by the
 * .htaccess rewrite rules for /en and /en/faq), but also recognizes an /en
 * URL path directly — so language switching still works even on servers
 * where .htaccess rewrites aren't applied (AllowOverride off, no mod_rewrite,
 * a different web server, a custom router, etc.). Persian is always the default.
 */
function resolveLang(): string {
    if (strtolower((string)($_GET['lang'] ?? '')) === 'en') {
        return 'en';
    }
    $path = (string)parse_url((string)($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if (preg_match('#(^|/)en(/|$)#', $path)) {
        return 'en';
    }
    return 'fa';
}

/**
 * Convert boolean-ish value into Persian Yes/No.
 */
function yesNo(?bool $value, array $translations): string {
    if ($value === null) return t('N/A', $translations);
    return $value ? t('Yes', $translations) : t('No', $translations);
}
