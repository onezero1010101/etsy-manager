<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}
require_once __DIR__ . '/../lib/db.php';

$stmt = $pdo->query("SELECT * FROM etsy_listings ORDER BY last_updated DESC");
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

function suggest_tags($title, $description) {
    $words = array_count_values(
        array_filter(
            preg_split('/\W+/', strtolower($title . ' ' . $description))
        )
    );
    arsort($words);
    return array_slice(array_keys($words), 0, 10);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Etsy Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>Etsy Listing Manager</h1>
    <a class="btn btn-warning mb-2" href="importer.php">🔄 Re-Import Listings</a>
    <a class="btn btn-danger mb-2 float-end" href="logout.php">Logout</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Image</th><th>Title</th><th>Quantity</th><th>SKU</th><th>Tags</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($listings as $item): ?>
            <tr>
                <form action="update.php" method="POST">
                <td>
                    <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/60') ?>" width="60">
                </td>
                <td>
                    <input class="form-control" type="text" name="title" value="<?= htmlspecialchars($item['title']) ?>">
                </td>
                <td><input class="form-control" type="number" name="quantity" value="<?= $item['quantity'] ?>"></td>
                <td><input class="form-control" type="text" name="sku" value="<?= htmlspecialchars($item['sku']) ?>"></td>
                <td>
                    <input class="form-control mb-1" type="text" name="tags" value="<?= htmlspecialchars(trim(implode(', ', json_decode($item['tags'] ?? '[]', true)))) ?>">
                    <small>Suggested: <?= implode(', ', suggest_tags($item['title'], $item['description'])) ?></small>
                </td>
                <td>
                    <input type="hidden" name="listing_id" value="<?= $item['listing_id'] ?>">
                    <button class="btn btn-primary" type="submit">Update</button>
                </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>