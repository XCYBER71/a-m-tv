<?php
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$conn = getDBConnection();

if (isset($data['total_visits'])) {
    $visits = intval($data['total_visits']);
    $conn->query("UPDATE stats SET stat_value = stat_value + $visits WHERE stat_key = 'total_visits'");
}

if (isset($data['online_users'])) {
    $online = intval($data['online_users']);
    $conn->query("UPDATE stats SET stat_value = $online WHERE stat_key = 'online_users'");
}

echo json_encode(['success' => true]);

$conn->close();
?>