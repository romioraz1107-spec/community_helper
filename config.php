<?php
// config.php
// Update these to match your MAMP settings.
// Default MAMP MySQL: user 'root', pass 'root', port 8889
$DB_HOST = 'localhost';
$DB_NAME = 'community_helper3';
$DB_USER = 'root';
$DB_PASS = 'root';
$DB_PORT = 8889; // MAMP default is 8889; XAMPP default is 3306

try {
    $dsn = "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}
function current_user_role() {
    return $_SESSION['role'] ?? null;
}
function h($str){ return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
?>
