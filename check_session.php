<?php
require_once 'config.php';

if (isAdminLoggedIn()) {
    echo json_encode(['logged_in' => true]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>