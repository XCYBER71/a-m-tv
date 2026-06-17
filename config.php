<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// ========== আপনার হোস্টিং এর তথ্য দিন ==========
define('DB_HOST', 'sql101.eyzyo.com');
define('DB_USER', 'ezyro_42163325');
define('DB_PASS', 'c14260dfbdd6d');
define('DB_NAME', 'ezyro_42163325_aminul');
// ============================================

// এরর রিপোর্টিং চালু করুন (ডিবাগিং এর জন্য)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        return $conn;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e->getMessage()]);
        exit();
    }
}

function isAdminLoggedIn() {
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        // সেশন টাইমআউট চেক (1 ঘণ্টা)
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > 3600) {
            session_destroy();
            return false;
        }
        return true;
    }
    return false;
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>