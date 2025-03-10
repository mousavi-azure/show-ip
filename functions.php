<?php
function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ip[0]);
    }

    if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        return $_SERVER['HTTP_X_REAL_IP'];
    }
    
    return $_SERVER['REMOTE_ADDR'];
}

function getIPData($ip, $apiKey) {
    $url = "https://api.ipdata.co/{$ip}?api-key={$apiKey}";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    // SSL Certificate fixes
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        return ['error' => 'API request failed: ' . curl_error($ch)];
    }
    
    curl_close($ch);
    
    return json_decode($response, true);
}
// Translation array for Persian
$translations = [
    'IP Details Lookup' => 'بررسی اطلاعات آی‌پی',
    'Your IP' => 'آی‌پی شما',
    'Location Information' => 'اطلاعات مکانی',
    'Country' => 'کشور',
    'Region' => 'منطقه',
    'City' => 'شهر',
    'Postal Code' => 'کد پستی',
    'Coordinates' => 'مختصات',
    'Network Information' => 'اطلاعات شبکه',
    'ISP' => 'ارائه دهنده خدمات اینترنت',
    'ASN' => 'شماره سیستم خودگردان',
    'Organization' => 'سازمان',
    'Time Zone' => 'منطقه زمانی',
    'Currency' => 'واحد پول',
    'Map Location' => 'موقعیت روی نقشه',
    'Additional Information' => 'اطلاعات تکمیلی',
    'Threat Information' => 'اطلاعات اضافی',
    'Is Tor' => 'استفاده از تور',
    'Is Proxy' => 'استفاده از پروکسی',
    'Is Anonymous' => 'ناشناس بودن',
    'Is Known Attacker' => 'مهاجم شناخته شده',
    'Is Known Abuser' => 'سوء استفاده کننده شناخته شده',
    'Raw API Response' => 'پاسخ خام API',
    'Yes' => 'بله',
    'No' => 'خیر',
    'N/A' => 'نامشخص',
    'Your Location' => 'موقعیت شما',
    'Note' => 'توجه',
    'Make sure to replace the placeholder API key with your actual IPData API key in the PHP code.' => 'مطمئن شوید که کلید API نمونه را با کلید IPData API واقعی خود در کد PHP جایگزین کرده‌اید.',
    'API request failed' => 'درخواست API با خطا مواجه شد'
];

// Function to translate text
function translate($text, $translations) {
    return isset($translations[$text]) ? $translations[$text] : $text;
}