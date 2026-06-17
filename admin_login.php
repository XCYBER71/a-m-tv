<?php
require_once 'config.php';

// ডিবাগ করার জন্য
error_log("Admin login attempt received");

$data = json_decode(file_get_contents('php://input'), true);
$username = isset($data['username']) ? sanitize($data['username']) : '';
$password = isset($data['password']) ? $data['password'] : '';

error_log("Username: " . $username);

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'Username and password required']);
    exit();
}

$conn = getDBConnection();

// প্রথমে admin_users টেবিলে ইউজার আছে কিনা চেক করুন
$check_sql = "SELECT COUNT(*) as count FROM admin_users";
$check_result = $conn->query($check_sql);
$check_row = $check_result->fetch_assoc();

error_log("Total admin users: " . $check_row['count']);

// ইউজার চেক করুন
$stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    error_log("User found: " . $row['username']);
    
    // পাসওয়ার্ড ভেরিফাই করুন (bcrypt)
    if (password_verify($password, $row['password_hash'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $username;
        $_SESSION['login_time'] = time();
        error_log("Login successful for: " . $username);
        echo json_encode(['success' => true]);
    } else {
        error_log("Password mismatch for: " . $username);
        echo json_encode(['success' => false, 'error' => 'Invalid password']);
    }
} else {
    error_log("User not found: " . $username);
    // যদি ইউজার না থাকে, তাহলে ডিফল্ট ইউজার তৈরি করুন
    $default_password = password_hash('mim123', PASSWORD_DEFAULT);
    $insert_stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
    $insert_stmt->bind_param("ss", $username, $default_password);
    
    if ($insert_stmt->execute()) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $username;
        $_SESSION['login_time'] = time();
        error_log("New admin user created: " . $username);
        echo json_encode(['success' => true]);
    } else {
        error_log("Failed to create admin user");
        echo json_encode(['success' => false, 'error' => 'Unable to create admin user']);
    }
    $insert_stmt->close();
}

$stmt->close();
$conn->close();
?>