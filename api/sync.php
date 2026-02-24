<?php
// api/sync.php
require_once 'config.php';
checkAuth();

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

// ایجاد پوشه data اگر وجود نداره
if (!file_exists(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0777, true);
}

// ذخیره داده‌ها
file_put_contents(__DIR__ . '/data/users.json', json_encode($input['users'] ?? [], JSON_PRETTY_PRINT));
file_put_contents(__DIR__ . '/data/banned.json', json_encode($input['bannedUsers'] ?? [], JSON_PRETTY_PRINT));
file_put_contents(__DIR__ . '/data/transactions.json', json_encode($input['transactions'] ?? [], JSON_PRETTY_PRINT));
file_put_contents(__DIR__ . '/data/wallets.json', json_encode($input['wallets'] ?? [], JSON_PRETTY_PRINT));
file_put_contents(__DIR__ . '/data/stats.json', json_encode($input['stats'] ?? [], JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);
?>
