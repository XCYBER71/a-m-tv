<?php
require_once 'config.php';

$conn = getDBConnection();

$result = $conn->query("SELECT setting_value FROM settings WHERE setting_key = 'site_name'");
$row = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'site_name' => $row['setting_value'] ?? 'A+M TV Stream'
]);

$conn->close();
?>