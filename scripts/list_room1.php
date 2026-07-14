<?php
require __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "ERROR: database file not found at {$dbPath}\n";
    exit(1);
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $stmt = $pdo->prepare('SELECT id, name, room, phone_number, whatsapp_notifications_enabled FROM users WHERE room = :room');
    $stmt->execute([':room' => 1]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) {
        echo "No users found in room 1\n";
        exit(0);
    }
    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
