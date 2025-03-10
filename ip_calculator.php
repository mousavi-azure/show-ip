<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// تابع برای تبدیل CIDR به Subnet Mask
function cidrToMask($cidr) {
    if ($cidr < 0 || $cidr > 32) {
        return false; // مقدار نامعتبر
    }
    return long2ip(-1 << (32 - $cidr)); // تبدیل CIDR به Subnet Mask
}

// تابع برای محاسبه تعداد میزبان‌ها
function calculateTotalHosts($subnetMask) {
    $maskBin = ip2long($subnetMask);
    $subnetBits = 32 - substr_count(decbin($maskBin), '1'); // شمارش تعداد 0‌ها در ماسک
    return pow(2, $subnetBits) - 2; // محاسبه تعداد میزبان‌ها
}

// تابع برای محاسبه آدرس شبکه، آدرس پخش، اولین و آخرین IP قابل استفاده
function calculateNetworkInfo($ip, $subnetMask) {
    // تبدیل IP و Subnet Mask به باینری
    $ipBin = ip2long($ip);
    $maskBin = ip2long($subnetMask);

    // محاسبه آدرس شبکه و پخش
    $network = long2ip($ipBin & $maskBin);  // AND عملیات برای آدرس شبکه
    $broadcast = long2ip(($ipBin & $maskBin) | (~$maskBin));  // OR عملیات برای آدرس پخش

    // اولین و آخرین IP قابل استفاده
    $firstUsable = long2ip(($ipBin & $maskBin) + 1);
    $lastUsable = long2ip(($ipBin & $maskBin) | (~$maskBin) - 1);

    // تعداد میزبان‌ها
    $totalHosts = calculateTotalHosts($subnetMask);

    return [
        'Network Address' => $network,
        'Broadcast Address' => $broadcast,
        'First Usable IP' => $firstUsable,
        'Last Usable IP' => $lastUsable,
        'Total Hosts' => $totalHosts,
    ];
}

// بررسی متد درخواست
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "متد غیرمجاز است"]);
    exit;
}

// بررسی مقدار ورودی
if (!isset($_POST['ip']) || !isset($_POST['subnet'])) {
    http_response_code(400);
    echo json_encode(["error" => "مقادیر ارسالی نامعتبر است"]);
    exit;
}

$ip = trim($_POST['ip']);
$subnet = trim($_POST['subnet']);

// اعتبارسنجی آی‌پی
if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    http_response_code(400);
    echo json_encode(["error" => "آدرس IP نامعتبر است"]);
    exit;
}

// تبدیل subnet از CIDR به Mask
if (strpos($subnet, '/') !== false) {
    // اگر subnet ورودی CIDR باشد
    $cidr = (int) substr($subnet, 1);
    $subnet = cidrToMask($cidr);
    if (!$subnet) {
        http_response_code(400);
        echo json_encode(["error" => "CIDR نامعتبر است"]);
        exit;
    }
} elseif (!filter_var($subnet, FILTER_VALIDATE_IP)) {
    // اگر subnet ورودی به صورت Mask باشد ولی نامعتبر باشد
    http_response_code(400);
    echo json_encode(["error" => "Subnet mask نامعتبر است"]);
    exit;
}

// محاسبات اضافی و نمایش خروجی
$networkInfo = calculateNetworkInfo($ip, $subnet);

// ایجاد نتیجه نهایی
$result = [
    "آدرس IP" => $ip,
    "Subnet Mask یا زیر شبکه" => $subnet,
    "آدرس شبکه" => $networkInfo['Network Address'],
    "آدرس برودکست" => $networkInfo['Broadcast Address'],
    "اولین آدرس قابل استفاده" => $networkInfo['First Usable IP'],
    "آخرین آدرس قابل استفاده" => $networkInfo['Last Usable IP'],
    "تعداد هاست" => $networkInfo['Total Hosts']
];

// ارسال داده‌ها به صورت JSON
echo json_encode($result);
exit;
?>
