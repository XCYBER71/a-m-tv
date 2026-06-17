<?php
require_once 'config.php';

$conn = getDBConnection();

// চ্যানেল কাউন্ট
$channel_result = $conn->query("SELECT COUNT(*) as total FROM channels WHERE enabled = 1");
$channel_row = $channel_result->fetch_assoc();
$total_channels = $channel_row['total'];

// ভিজিটর স্ট্যাট
$stats_result = $conn->query("SELECT stat_key, stat_value FROM stats");
$stats = [];
while ($row = $stats_result->fetch_assoc()) {
    $stats[$row['stat_key']] = $row['stat_value'];
}

echo json_encode([
    'success' => true,
    'total_channels' => $total_channels,
    'total_visits' => isset($stats['total_visits']) ? $stats['total_visits'] : 0,
    'online_users' => isset($stats['online_users']) ? $stats['online_users'] : rand(100, 500)
]);

$conn->close();
?>