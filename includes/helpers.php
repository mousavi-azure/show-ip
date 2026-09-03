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

/**
 * Localize a geo display value (country/continent/region/city) into Persian
 * using the tables from includes/geo-fa.php. ipdata.co always returns these
 * in English; on the English site (or values it has no translation for) the
 * original string passes through unchanged.
 *
 * @param array<string,string> $table looked up by ISO code first (countries/
 *   continents), then by lowercase English name (region/city, which have no
 *   reliable global code) — pass $code only when the table is code-keyed.
 */
function geoLocalize(string $value, string $lang, array $table, string $code = ''): string {
    if ($lang !== 'fa' || $value === '') {
        return $value;
    }
    if ($code !== '' && isset($table[$code])) {
        return $table[$code];
    }
    return $table[mb_strtolower($value)] ?? $value;
}

/**
 * Convert Western digits in a string to Persian (Eastern Arabic) digits.
 */
function faDigits(string $value): string {
    return strtr($value, ['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']);
}

/**
 * Convert a Gregorian Y-m-d date to a Jalali (Shamsi) date string in Persian,
 * e.g. "2026-09-03" -> "۱۳ شهریور ۱۴۰۵". Pure arithmetic, no ext/intl or
 * database needed. Returns the input unchanged if it cannot be parsed.
 */
function jalaliDate(string $iso): string {
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $iso, $m)) {
        return $iso;
    }
    [$gy, $gm, $gd] = [(int)$m[1], (int)$m[2], (int)$m[3]];

    $gDaysCum = [0,31,59,90,120,151,181,212,243,273,304,334];
    $gy2 = $gm > 2 ? $gy + 1 : $gy;
    $days = 355666 + (365 * $gy) + intdiv($gy2 + 3, 4) - intdiv($gy2 + 99, 100)
          + intdiv($gy2 + 399, 400) + $gd + $gDaysCum[$gm - 1];

    $jy = -1595 + (33 * intdiv($days, 12053));
    $days %= 12053;
    $jy += 4 * intdiv($days, 1461);
    $days %= 1461;
    if ($days > 365) {
        $jy += intdiv($days - 1, 365);
        $days = ($days - 1) % 365;
    }
    if ($days < 186) {
        $jm = 1 + intdiv($days, 31);
        $jd = 1 + ($days % 31);
    } else {
        $jm = 7 + intdiv($days - 186, 30);
        $jd = 1 + (($days - 186) % 30);
    }

    $months = ['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور',
               'مهر','آبان','آذر','دی','بهمن','اسفند'];
    return faDigits($jd . ' ' . $months[$jm - 1] . ' ' . $jy);
}

/**
 * Human-facing publish/update date: Jalali + Persian digits on the Persian
 * site, ISO on the English one.
 */
function displayDate(string $iso, string $lang): string {
    return $lang === 'fa' ? jalaliDate($iso) : $iso;
}

/**
 * Resolve the requested blog article slug, if any. Prefers the `slug` query
 * param (set by the .htaccess rewrite rules), but also parses it straight
 * out of the URL path as a fallback — same resilience reasoning as
 * resolveLang(): it must keep working even if .htaccess rewrites for
 * /blog/{slug} aren't applied on a given server.
 */
function resolveBlogSlug(): ?string {
    $slug = strtolower((string)($_GET['slug'] ?? ''));
    if ($slug !== '' && preg_match('/^[a-z0-9-]+$/', $slug)) {
        return $slug;
    }
    $path = (string)parse_url((string)($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if (preg_match('#/blog/([a-z0-9-]+)/?$#', $path, $m)) {
        return $m[1];
    }
    return null;
}
