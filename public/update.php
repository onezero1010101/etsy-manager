<?php
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/etsy_api.php';
$config = require __DIR__ . '/../config/config.php';

session_start();
$access_token = $_SESSION['access_token'] ?? $config['access_token'];
if (!$access_token) die('Missing token');

$listing_id = $_POST['listing_id'];
$title = $_POST['title'];
$quantity = (int) $_POST['quantity'];
$sku = $_POST['sku'];
$tags = explode(',', $_POST['tags']);
$tags = array_map('trim', $tags);

$data = [
    "title" => $title,
    "quantity" => $quantity,
    "sku" => [$sku],
    "tags" => $tags
];

$response = etsy_update_listing($access_token, $listing_id, $data);

if (isset($response['error'])) {
    die("Update failed: " . $response['error']);
}

$stmt = $pdo->prepare("UPDATE etsy_listings SET title = ?, quantity = ?, sku = ?, tags = ?, last_updated = NOW() WHERE listing_id = ?");
$stmt->execute([$title, $quantity, json_encode([$sku]), json_encode($tags), $listing_id]);

header("Location: index.php");
exit;