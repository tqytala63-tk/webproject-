<?php
session_start();
require 'config.php';

if(!isset($_POST['requestID'])) die("⚠ RequestID مفقود");
$requestID = $_POST['requestID'];

// تحديث الحالة إلى "مقبول"
$stmt = $pdo->prepare("UPDATE Requests SET Status = 'مقبول' WHERE RequestID = ?");
$stmt->execute([$requestID]);

// تخزين رسالة في الـ session
$_SESSION['message'] = "تم قبول الطلب بنجاح!";

// إعادة التوجيه للصفحة الرئيسية / dashboard
header("Location: request.php");
exit;
?>

