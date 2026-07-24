<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$lang = (($_POST['lang'] ?? '') === 'en') ? 'en' : 'fa';

$MESSAGES = [
    'fa' => [
        'method_not_allowed' => 'روش درخواست مجاز نیست.',
        'missing_fields'     => 'لطفاً آدرس IP و Subnet Mask یا CIDR را وارد کنید!',
        'invalid_ipv4'       => 'فقط IPv4 پشتیبانی می‌شود و آی‌پی باید معتبر باشد.',
        'invalid_cidr'       => 'CIDR نامعتبر است.',
        'invalid_mask'       => 'Subnet Mask نامعتبر است.',
        'mask_not_contiguous'=> 'Subnet Mask باید پیوسته باشد.',
        'invalid_ip_or_mask' => 'آی‌پی یا Subnet Mask نامعتبر است.',
    ],
    'en' => [
        'method_not_allowed' => 'Method not allowed.',
        'missing_fields'     => 'Please enter both an IP address and a subnet mask or CIDR.',
        'invalid_ipv4'       => 'Only IPv4 is supported, and the address must be valid.',
        'invalid_cidr'       => 'Invalid CIDR value.',
        'invalid_mask'       => 'Invalid subnet mask.',
        'mask_not_contiguous'=> 'Subnet mask bits must be contiguous.',
        'invalid_ip_or_mask' => 'Invalid IP address or subnet mask.',
    ],
][$lang];

function respond(array $payload, int $status = 200): void {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function cidrToMask(int $cidr, array $messages): string {
    if ($cidr < 0 || $cidr > 32) {
        throw new InvalidArgumentException($messages['invalid_cidr']);
    }
    return long2ip((int)(~((1 << (32 - $cidr)) - 1)));
}

function maskToCidr(string $mask, array $messages): int {
    $long = ip2long($mask);
    if ($long === false) {
        throw new InvalidArgumentException($messages['invalid_mask']);
    }
    $bin = str_pad(decbin($long), 32, '0', STR_PAD_LEFT);
    if (preg_match('/01/', $bin)) { // not contiguous
        throw new InvalidArgumentException($messages['mask_not_contiguous']);
    }
    return substr_count($bin, '1');
}

function calculateNetwork(string $ip, string $mask, array $messages): array {
    $ipLong = ip2long($ip);
    $maskLong = ip2long($mask);

    if ($ipLong === false || $maskLong === false) {
        throw new InvalidArgumentException($messages['invalid_ip_or_mask']);
    }

    $networkLong = $ipLong & $maskLong;
    $broadcastLong = $networkLong | (~$maskLong & 0xFFFFFFFF);

    $cidr = maskToCidr($mask, $messages);
    $hostBits = 32 - $cidr;
    $totalHosts = ($hostBits === 0) ? 1 : (1 << $hostBits);
    $usableHosts = ($cidr >= 31) ? $totalHosts : max($totalHosts - 2, 0);

    $firstUsable = ($cidr >= 31) ? $networkLong : $networkLong + 1;
    $lastUsable = ($cidr >= 31) ? $broadcastLong : $broadcastLong - 1;

    return [
        'ip' => $ip,
        'subnet_mask' => $mask,
        'cidr' => '/' . $cidr,
        'network_address' => long2ip($networkLong),
        'broadcast_address' => long2ip($broadcastLong),
        'first_usable' => long2ip($firstUsable),
        'last_usable' => long2ip($lastUsable),
        'total_addresses' => $totalHosts,
        'usable_hosts' => $usableHosts,
        'host_bits' => $hostBits,
    ];
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond(['error' => $MESSAGES['method_not_allowed']], 405);
    }

    $ip = trim((string)($_POST['ip'] ?? ''));
    $subnet = trim((string)($_POST['subnet'] ?? ''));

    if ($ip === '' || $subnet === '') {
        respond(['error' => $MESSAGES['missing_fields']], 422);
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        respond(['error' => $MESSAGES['invalid_ipv4']], 422);
    }

    // subnet can be mask or /cidr
    if (preg_match('/^\/(\d{1,2})$/', $subnet, $m)) {
        $mask = cidrToMask((int)$m[1], $MESSAGES);
    } else {
        $mask = $subnet;
    }

    $result = calculateNetwork($ip, $mask, $MESSAGES);
    respond(['ok' => true, 'result' => $result]);

} catch (Throwable $e) {
    respond(['error' => $e->getMessage()], 500);
}
