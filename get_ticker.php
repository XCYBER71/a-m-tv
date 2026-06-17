<?php
require_once 'config.php';

$conn = getDBConnection();

$result = $conn->query("SELECT * FROM ticker_messages ORDER BY id DESC");

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row['message'];
}

if (empty($messages)) {
    $messages = ["🛡️ Welcome to A+M TV Stream"];
}

echo json_encode(['success' => true, 'messages' => $messages]);

$conn->close();
?>