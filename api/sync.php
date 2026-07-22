<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');

$API_KEY = 'TonDropy@1403SecretKey';

// بررسی کلید
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

$headers = getallheaders();
if (!isset($headers['X-API-Key']) || $headers['X-API-Key'] !== $API_KEY) {
    http_response_code(403);
    die(json_encode(['error' => 'Unauthorized']));
}

// Health check
if (isset($_GET['health']) || isset($_GET['ping'])) {
    die(json_encode(['status' => 'ok', 'time' => time()]));
}

// دریافت داده
$input = file_get_contents('php://input');
if (!$input) {
    http_response_code(400);
    die(json_encode(['error' => 'No data']));
}

$data = json_decode($input, true);
if (!$data) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid JSON']));
}

// ذخیره در فایل یا دیتابیس
$backupDir = __DIR__ . '/backups/';
if (!is_dir($backupDir)) mkdir($backupDir, 0777, true);

$filename = $backupDir . 'data_' . date('Y-m-d') . '.json';
file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// پاسخ
echo json_encode(['status' => 'ok', 'received' => count($data['users'] ?? []) . ' users']);
