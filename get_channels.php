<?php
require_once 'config.php';

$conn = getDBConnection();

$sql = "SELECT * FROM channels WHERE enabled = 1 ORDER BY id ASC";
$result = $conn->query($sql);

$channels = [];
while ($row = $result->fetch_assoc()) {
    $channels[] = $row;
}

// ক্যাটাগরি লিস্ট
$cat_sql = "SELECT DISTINCT category FROM channels WHERE enabled = 1 AND category IS NOT NULL AND category != '' ORDER BY category";
$cat_result = $conn->query($cat_sql);

$categories = ['All'];
while ($row = $cat_result->fetch_assoc()) {
    if ($row['category']) $categories[] = $row['category'];
}

echo json_encode([
    'success' => true,
    'channels' => $channels,
    'categories' => $categories
]);

$conn->close();
?>