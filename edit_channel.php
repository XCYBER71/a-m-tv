<?php
require_once 'config.php';

if (!isAdminLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$id = intval($data['id'] ?? 0);
$name = sanitize($data['name'] ?? '');
$logo = sanitize($data['logo'] ?? '');
$stream_url = sanitize($data['stream_url'] ?? '');
$category = sanitize($data['category'] ?? '');
$country = sanitize($data['country'] ?? '');

if ($id <= 0 || empty($name)) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit();
}

$conn = getDBConnection();

$stmt = $conn->prepare("UPDATE channels SET name=?, logo=?, stream_url=?, category=?, country=? WHERE id=?");
$stmt->bind_param("sssssi", $name, $logo, $stream_url, $category, $country, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>