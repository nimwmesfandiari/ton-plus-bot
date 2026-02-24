<?php
// api/action.php
require_once 'config.php';
checkAuth();

$action = $_GET['action'] ?? '';
$userId = $_GET['user_id'] ?? '';

if (!$userId) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID required']);
    exit;
}

$usersFile = __DIR__ . '/data/users.json';
$bannedFile = __DIR__ . '/data/banned.json';

if (!file_exists($usersFile)) {
    echo json_encode(['success' => false, 'error' => 'Users file not found']);
    exit;
}

$users = json_decode(file_get_contents($usersFile), true);
$banned = file_exists($bannedFile) ? json_decode(file_get_contents($bannedFile), true) : [];

if ($action === 'ban') {
    if (!in_array($userId, $banned)) {
        $banned[] = $userId;
        file_put_contents($bannedFile, json_encode($banned, JSON_PRETTY_PRINT));
    }
    echo json_encode(['success' => true]);
} 
elseif ($action === 'unban') {
    $banned = array_filter($banned, fn($id) => $id != $userId);
    file_put_contents($bannedFile, json_encode(array_values($banned), JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
} 
elseif ($action === 'delete') {
    $users = array_filter($users, fn($u) => $u['id'] != $userId);
    $banned = array_filter($banned, fn($id) => $id != $userId);
    file_put_contents($usersFile, json_encode(array_values($users), JSON_PRETTY_PRINT));
    file_put_contents($bannedFile, json_encode(array_values($banned), JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
} 
else {
    echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>
