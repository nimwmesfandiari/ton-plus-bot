<?php
// api/users.php
require_once 'config.php';
checkAuth();

$page = intval($_GET['page'] ?? 1);
$limit = intval($_GET['limit'] ?? 20);
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

$usersFile = __DIR__ . '/data/users.json';
if (file_exists($usersFile)) {
    $users = json_decode(file_get_contents($usersFile), true);
} else {
    $users = [];
}

// اعمال فیلتر
if ($filter === 'banned') {
    $bannedFile = __DIR__ . '/data/banned.json';
    $banned = file_exists($bannedFile) ? json_decode(file_get_contents($bannedFile), true) : [];
    $users = array_filter($users, fn($u) => in_array($u['id'], $banned));
} elseif ($filter === 'wallets') {
    $users = array_filter($users, fn($u) => !empty($u['wallet']));
}

// جستجو
if (!empty($search)) {
    $users = array_filter($users, function($u) use ($search) {
        $s = strtolower($search);
        return str_contains(strtolower($u['firstName'] ?? ''), $s) ||
               str_contains(strtolower($u['lastName'] ?? ''), $s) ||
               str_contains(strtolower($u['username'] ?? ''), $s) ||
               str_contains($u['id'] ?? '', $s) ||
               str_contains(strtolower($u['wallet'] ?? ''), $s);
    });
}

// صفحه‌بندی
$total = count($users);
$total_pages = ceil($total / $limit);
$users = array_slice(array_values($users), ($page - 1) * $limit, $limit);

echo json_encode([
    'users' => $users,
    'page' => $page,
    'limit' => $limit,
    'total' => $total,
    'total_pages' => $total_pages
]);
?>
