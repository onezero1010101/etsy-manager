<?php
session_start();
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/etsy_api.php';

$access_token = $_SESSION['access_token'] ?? null;
$shop_id = getenv('ETSY_SHOP_ID');
if (!$access_token) die('Not authenticated');

$listings = etsy_get_listings($access_token, $shop_id);

foreach ($listings as $item) {
    // Get primary image
    $image_url = '';
    if (!empty($item['images'][0]['url_75x75'])) {
        $image_url = $item['images'][0]['url_75x75'];
    }

    $stmt = $pdo->prepare("REPLACE INTO etsy_listings 
        (listing_id, title, description, quantity, sku, price, tags, state, image_url, last_updated)
        VALUES 
        (:listing_id, :title, :description, :quantity, :sku, :price, :tags, :state, :image_url, NOW())");

    $stmt->execute([
        ':listing_id' => $item['listing_id'],
        ':title' => $item['title'],
        ':description' => $item['description'],
        ':quantity' => $item['quantity'],
        ':sku' => json_encode($item['sku']),
        ':price' => isset($item['price']['amount']) ? $item['price']['amount'] / 100 : 0,
        ':tags' => json_encode($item['tags']),
        ':state' => $item['state'],
        ':image_url' => $image_url
    ]);
}

header("Location: index.php");