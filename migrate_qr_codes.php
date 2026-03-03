<?php

$db_path = __DIR__ . '/database/database.sqlite';
$db = new PDO('sqlite:' . $db_path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "CREATE TABLE IF NOT EXISTS qr_codes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    image_path TEXT NOT NULL,
    is_active INTEGER DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
)";

try {
    $db->exec($sql);
    echo "Table 'qr_codes' created successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
