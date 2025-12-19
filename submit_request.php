<?php
session_start();
require 'config.php';

// تأكد أن المستخدم مسجّل دخول
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['user_id'];

// تأكد أن مجلد qrcodes موجود، إذا لا أنشئه
if(!file_exists('qrcodes')){
    mkdir('qrcodes', 0777, true);
}

// استدعاء مكتبة PHP QR Code
include "phpqrcode\phpqrcode/qrlib.php";


// مثال: المستخدم يختار نوع الخدمة
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $transactionType = $_POST['transaction_type']; // مثلاً: "BirthExtract"
var_dump($userID);

    // إدخال الطلب في جدول Requests
    $stmt = $pdo->prepare("INSERT INTO Requests (UserID, TransactionType) VALUES (?, ?)");
    $stmt->execute([$userID, $transactionType]);
    $requestID = $pdo->lastInsertId();

    // توليد نص QR (مثلاً: رقم الطلب + نوع الخدمة + userID)
    $qrText = "RequestID: $requestID\nUserID: $userID\nType: $transactionType";

    // مسار حفظ QR
    $qrFile = "qrcodes/request_$requestID.png";

    // توليد QR Code
    QRcode::png($qrText, $qrFile, 'L', 4, 2);

    // تحديث جدول Requests ليضيف مسار QR
    $stmt = $pdo->prepare("UPDATE Requests SET QRCode = ? WHERE RequestID = ?");
    $stmt->execute([$qrFile, $requestID]);

    echo "<script>alert('تم تقديم الطلب بنجاح!'); window.location.href='my_requests.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تقديم طلب جديد</title>
<style>
body { font-family: 'Cairo', sans-serif; padding: 20px; background: #f7fafc; }
form { max-width: 400px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(10,112,117,0.1); }
input, select, button { width: 100%; padding: 12px; margin: 10px 0; border-radius: 6px; border: 1px solid #ccc; }
button { background: #0A7075; color: white; border: none; cursor: pointer; }
button:hover { background: #095d62; }
</style>
</head>
<body>
<h2 style="text-align:center; color:#0A7075;">تقديم طلب جديد</h2>

<form method="POST">
    <label>نوع الخدمة</label>
    <select name="transaction_type" required>
        <option value="">اختر نوع الخدمة</option>
        <option value="BirthExtract">إخراج قيد فردي</option>
        <option value="FamilyExtract">إخراج قيد عائلي</option>
        <option value="IDCard">بطاقة الهوية</option>
        <option value="BirthCertificate">وثيقة ولادة</option>
        <option value="DeathCertificate">وثيقة وفاة</option>
        <option value="MarriageCertificate">وثيقة زواج</option>
    </select>
    <button type="submit">إرسال الطلب</button>
</form>
</body>
</html>
