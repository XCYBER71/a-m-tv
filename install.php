<?php
require_once 'api/config.php';

echo "<h2>Database Installation for A+M TV IPTV CMS</h2>";

$conn = getDBConnection();

// চ্যানেল টেবিল
$sql1 = "CREATE TABLE IF NOT EXISTS channels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(500),
    stream_url VARCHAR(1000) NOT NULL,
    category VARCHAR(50),
    country VARCHAR(50),
    enabled TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// টিকার মেসেজ টেবিল
$sql2 = "CREATE TABLE IF NOT EXISTS ticker_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// সেটিংস টেবিল
$sql3 = "CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// স্ট্যাটিসটিক্স টেবিল
$sql4 = "CREATE TABLE IF NOT EXISTS stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stat_key VARCHAR(50) UNIQUE NOT NULL,
    stat_value INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// অ্যাডমিন ইউজার টেবিল
$sql5 = "CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// টেবিল তৈরি
$conn->query($sql1);
echo "<p>✓ Channels table created</p>";

$conn->query($sql2);
echo "<p>✓ Ticker messages table created</p>";

$conn->query($sql3);
echo "<p>✓ Settings table created</p>";

$conn->query($sql4);
echo "<p>✓ Stats table created</p>";

$conn->query($sql5);
echo "<p>✓ Admin users table created</p>";

// ডিফল্ট চ্যানেল ডাটা
$conn->query("INSERT IGNORE INTO channels (id, name, logo, stream_url, category, country) VALUES
(1, 'FIFA World Cup Official', 'https://flagsapi.com/QA/flat/64.png', 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', 'FIFA World Cup', 'Qatar'),
(2, 'ESPN HD', 'https://i.imgur.com/kJj1y0M.png', 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', 'Sports', 'USA'),
(3, 'Sony Sports', 'https://i.imgur.com/7e5Z1T9.png', 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4', 'Sports', 'India'),
(4, 'Bangladesh TV', 'https://flagcdn.com/bd.svg', 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', 'Bangladesh', 'Bangladesh'),
(5, 'MoviePlus', 'https://via.placeholder.com/80?text=Movies', 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4', 'Movies', 'Global')");
echo "<p>✓ Default channels inserted</p>";

// ডিফল্ট টিকার মেসেজ
$conn->query("INSERT IGNORE INTO ticker_messages (message) VALUES
('⚡ SECURE STREAM: FIFA World Cup 2026 Qualifiers Live'),
('🛡️ A+M TV Protected Platform • Buffer-Free 4K'),
('🔐 Admin panel fully secured with database')");
echo "<p>✓ Default ticker messages inserted</p>";

// ডিফল্ট সেটিংস
$conn->query("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
('site_name', 'A+M TV Stream'),
('maintenance_mode', '0')");
echo "<p>✓ Default settings inserted</p>";

// ডিফল্ট স্ট্যাটিসটিক্স
$conn->query("INSERT IGNORE INTO stats (stat_key, stat_value) VALUES
('total_visits', 28470),
('online_users', 412)");
echo "<p>✓ Default stats inserted</p>";

// অ্যাডমিন ইউজার তৈরি (পাসওয়ার্ড: mim123)
$password_hash = password_hash('mim123', PASSWORD_DEFAULT);
$conn->query("INSERT IGNORE INTO admin_users (username, password_hash) VALUES ('AMINUL', '$password_hash')");
echo "<p>✓ Admin user created (Username: AMINUL, Password: mim123)</p>";

echo "<h3>Installation Complete!</h3>";
echo "<a href='admin.html'>Go to Admin Panel</a> | <a href='index.html'>Go to Website</a>";

$conn->close();
?>