<?php
session_start();
require 'config.php'; // تأكدي إنو فيه الاتصال بقاعدة البيانات $pdo

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // تحديث آخر وقت خروج المستخدم
    $stmt = $pdo->prepare("UPDATE users SET LastLogout = NOW() WHERE UserID = ?");
    $stmt->execute([$user_id]);
}

// مسح كل بيانات الجلسة
$_SESSION = [];

// حذف الكوكيز تبع الجلسة
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// تدمير الجلسة نهائيًا
session_destroy();

// تحويل لصفحة تسجيل الدخول
header("Location: login.php");
exit;
?>
