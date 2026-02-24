<?php
// api/config.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');

// تنظیمات امنیتی - کلید مخفی برای ارتباط با پنل مدیریت
define('API_SECRET_KEY', 'TonDropy@1403SecretKey');

// توکن ربات تلگرام و اطلاعات ادمین (برای استفاده‌های بعدی)
define('BOT_TOKEN', '8047223304:AAHMW8a6tKTTSQOp4Os_LorRJzDLNvxz-Rw');
define('ADMIN_ID', '5972276401');
define('ADMIN_USERNAME', 'miningertoncoin');
define('WALLET_ADDRESS', 'UQDFlvMPZoQy4zySI8gLLMteRcxHRB28IHW0JuwFVk10u0Y');
define('SECRET_CODES', json_encode(['T61O96N12', 'VipTonDropy']));

// بررسی کلید امنیتی
function checkAuth() {
    $headers = getallheaders();
    $key = $headers['X-API-Key'] ?? '';
    if ($key !== API_SECRET_KEY) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
}

// اگر درخواست OPTIONS بود (برای CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
?>
