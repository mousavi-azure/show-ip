<?php
declare(strict_types=1);

/**
 * Fetch IP info from ipdata.co
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
        return ['error' => 'درخواست به سرویس آی‌پی با خطا مواجه شد: ' . $err];
    }

    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if (!is_array($data)) {
        return ['error' => 'پاسخ نامعتبر از سرویس آی‌پی دریافت شد.'];
    }

    // normalize common errors
    if ($status >= 400) {
        $message = $data['message'] ?? $data['error'] ?? ('HTTP ' . $status);
        return ['error' => (string)$message, 'status' => $status];
    }

    return $data;
}
