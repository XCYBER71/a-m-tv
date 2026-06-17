<?php
require_once 'config.php';

if (!isAdminLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$message = sanitize($data['message'] ?? '');

if (empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Message is required']);
    exit();
}

$conn = getDBConnection();

$stmt = $conn->prepare("INSERT INTO ticker_messages (message) VALUES (?)");
$stmt->bind_param("s", $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>