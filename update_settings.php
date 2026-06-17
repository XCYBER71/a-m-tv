<?php
require_once 'config.php';

if (!isAdminLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$site_name = sanitize($data['site_name'] ?? '');

$conn = getDBConnection();

$stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'site_name'");
$stmt->bind_param("s", $site_name);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>