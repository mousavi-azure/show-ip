<?php
declare(strict_types=1);

/**
 * Minimal .env loader (KEY=VALUE per line, '#' comments, optional quotes).
 * Avoids pulling in a Composer dependency for something this small.
 */
function loadEnvFile(string $path): void {
    if (!is_readable($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ($key === '') {
            continue;
        }
        if (strlen($value) >= 2 && $value[0] === $value[-1] && ($value[0] === '"' || $value[0] === "'")) {
            $value = substr($value, 1, -1);
        }
        if (getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

loadEnvFile(dirname(__DIR__) . '/.env');

define('APP_VERSION', '1.0.0');
define('APP_NAME', getenv('APP_NAME') ?: 'Show-IP.ir');
define('APP_URL', rtrim(getenv('APP_URL') ?: 'https://show-ip.ir', '/'));
define('APP_AUTHOR', getenv('APP_AUTHOR') ?: 'Mostafa Mousavi');
define('APP_AUTHOR_URL', getenv('APP_AUTHOR_URL') ?: 'https://mousavi.dev');

/*
 * API keys. ipdata.co free keys burn through their daily quota quickly, so the
 * site accepts a pool of them and rotates to the next one the moment a key is
 * rejected (quota exceeded / disabled / rate-limited). Provide them either as a
 * comma- or whitespace-separated list in IPDATA_API_KEYS, or the single legacy
 * API_KEY / IPDATA_API_KEY — all sources are merged and de-duplicated.
 */
$keyPool = [];
foreach ([getenv('IPDATA_API_KEYS'), getenv('API_KEY'), getenv('IPDATA_API_KEY')] as $raw) {
    if (!$raw) {
        continue;
    }
    foreach (preg_split('/[\s,]+/', (string)$raw) ?: [] as $k) {
        $k = trim($k);
        if ($k !== '') {
            $keyPool[] = $k;
        }
    }
}
$keyPool = array_values(array_unique($keyPool));

define('IPDATA_API_KEYS', $keyPool);
define('IPDATA_API_KEY', $keyPool[0] ?? ''); // kept for backward compatibility
define('IPDATA_VERIFY_SSL', (getenv('IPDATA_VERIFY_SSL') ?: 'true') === 'true');
define('IPDATA_TIMEOUT', (int)(getenv('IPDATA_TIMEOUT') ?: '15'));
define('IPDATA_CACHE_TTL', (int)(getenv('IPDATA_CACHE_TTL') ?: '1800'));
