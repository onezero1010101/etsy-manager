<?php
$config = require __DIR__ . '/../config/config.php';
$db = $config['db'];

try {
    $pdo = new PDO("mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4", $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}