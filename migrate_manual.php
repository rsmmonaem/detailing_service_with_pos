<?php

$db_path = __DIR__ . '/database/database.sqlite';
$db = new PDO('sqlite:' . $db_path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "CREATE TABLE IF NOT EXISTS services (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    default_amount DECIMAL(10, 2) NOT NULL,
    icon TEXT,
    is_active INTEGER DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
)";

try {
    $db->exec($sql);
    echo "Table 'services' created successfully.\n";
    
    // Seed default services
    $services = [
        ['Car Wash', 15.00, 'Car Wash', 1],
        ['Polish', 120.00, 'Polish', 1],
        ['Tinted', 350.00, 'Tinted', 1],
        ['Other', 0.00, 'Other', 1],
    ];
    
    $stmt = $db->prepare("INSERT INTO services (name, default_amount, icon, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, datetime('now'), datetime('now'))");
    foreach ($services as $s) {
        $stmt->execute($s);
    }
    echo "Default services seeded successfully.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
