<?php
declare(strict_types=1);

/**
 * Fetch IP info from ipdata.co (single API key).
 *
 * @return array<string,mixed>
 */
function fetchIpData(string $ip, string $apiKey, bool $verifySSL = true, int $timeout = 15): array {
    if ($apiKey === '') {
        return ['error' => 'کلید API تنظیم نشده است.'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return ['error' => 'آدرس IP نامعتبر است.'];
    }

    $url = "https://api.ipdata.co/" . rawurlencode($ip) . "?api-key=" . rawurlencode($apiKey);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_CONNECTTIMEOUT => min(5, $timeout),
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        CURLOPT_SSL_VERIFYPEER => $verifySSL,
        CURLOPT_SSL_VERIFYHOST => $verifySSL ? 2 : 0,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'User-Agent: show-ip/1.0 (+'.APP_URL.')'
        ],
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        $err = curl_error($ch);
        curl_close($ch);
        return ['error' => 'درخواست به سرویس آی‌پی با خطا مواجه شد: ' . $err, 'status' => 0];
    }

    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if (!is_array($data)) {
        return ['error' => 'پاسخ نامعتبر از سرویس آی‌پی دریافت شد.', 'status' => $status];
    }

    // normalize common errors
    if ($status >= 400) {
        $message = $data['message'] ?? $data['error'] ?? ('HTTP ' . $status);
        return ['error' => (string)$message, 'status' => $status];
    }

    return $data;
}

/**
 * Whether an error result from fetchIpData() means "this key is spent" —
 * quota exceeded, key disabled/invalid, or rate-limited. In every one of
 * these cases the very next key in the pool may still work, so we rotate.
 *
 * @param array<string,mixed> $result
 */
function ipKeyExhausted(array $result): bool {
    if (!isset($result['error'])) {
        return false;
    }
    $status = (int)($result['status'] ?? 0);
    if (in_array($status, [401, 403, 429], true)) {
        return true;
    }
    $msg = mb_strtolower((string)$result['error']);
    foreach (['quota', 'exceeded', 'upgrade to a paid plan', 're-activate', 'forbidden', 'unauthorized', 'rate limit'] as $needle) {
        if (str_contains($msg, $needle)) {
            return true;
        }
    }
    return false;
}

/**
 * Fetch IP info trying each API key in turn. As soon as one key is rejected
 * for a quota/auth/rate-limit reason we immediately fall through to the next
 * one — no delay, no extra round-trip. Any other kind of error (invalid IP,
 * network failure, bad JSON) is returned straight away because rotating keys
 * would not help.
 *
 * @param array<int,string> $apiKeys
 * @return array<string,mixed>
 */
function fetchIpDataMulti(string $ip, array $apiKeys, bool $verifySSL = true, int $timeout = 15): array {
    $apiKeys = array_values(array_unique(array_filter(array_map('trim', $apiKeys), static fn($k) => $k !== '')));
    if ($apiKeys === []) {
        return ['error' => 'کلید API تنظیم نشده است.'];
    }

    $last = ['error' => 'کلید API تنظیم نشده است.'];
    foreach ($apiKeys as $i => $key) {
        $result = fetchIpData($ip, $key, $verifySSL, $timeout);
        if (!isset($result['error'])) {
            return $result;
        }
        $last = $result;
        if (!ipKeyExhausted($result)) {
            return $result; // not a key problem — more keys won't help
        }
        // else: try the next key
    }
    return $last;
}

/**
 * Same as fetchIpDataMulti(), but backed by a short-lived on-disk cache keyed
 * by IP. Repeat visitors and page reloads are served from disk in well under a
 * millisecond and never touch the ipdata.co quota at all — this is the single
 * biggest lever on both speed and API-credit consumption.
 *
 * @param array<int,string> $apiKeys
 * @return array<string,mixed>
 */
function fetchIpDataCached(string $ip, array $apiKeys, bool $verifySSL = true, int $timeout = 15, int $ttl = 1800): array {
    if ($ttl <= 0 || !filter_var($ip, FILTER_VALIDATE_IP)) {
        return fetchIpDataMulti($ip, $apiKeys, $verifySSL, $timeout);
    }

    $dir = dirname(__DIR__) . '/.cache/ipdata';
    $file = $dir . '/' . sha1($ip) . '.json';

    if (is_readable($file) && (time() - filemtime($file)) < $ttl) {
        $cached = json_decode((string)file_get_contents($file), true);
        if (is_array($cached) && !isset($cached['error'])) {
            $cached['_cache'] = 'hit';
            return $cached;
        }
    }

    $result = fetchIpDataMulti($ip, $apiKeys, $verifySSL, $timeout);

    if (!isset($result['error'])) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        if (is_dir($dir) && is_writable($dir)) {
            @file_put_contents(
                $file,
                json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                LOCK_EX
            );
        }
    }

    return $result;
}
