<?php
// api/config.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');

// کلید امنیتی - حتماً این رو عوض کنید
define('API_SECRET_KEY', 'TonDropy@1403SecretKey');

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

// اگر درخواست OPTIONS بود
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
?>
