<?php
// api/stats.php
require_once 'config.php';
checkAuth();

$statsFile = __DIR__ . '/data/stats.json';
if (file_exists($statsFile)) {
    $stats = json_decode(file_get_contents($statsFile), true);
} else {
    $stats = [
        'total_users' => 0,
        'active_today' => 0,
        'wallets' => 0,
        'banned' => 0,
        'total_mined' => 0,
        'transactions' => 0
    ];
}

echo json_encode($stats);
?>
