<?php
$host = 'localhost';
$db   = 'civilregistrydb';  
$user = 'root';             
$pass = '';                
$charset = 'utf8mb4';


$server_url = '192.168.1.5'; // ضع عنوان IP هنا (مثال: '192.168.1.105')

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // فتح الجلسة إذا ما كانت مفتوحة أصلاً
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
