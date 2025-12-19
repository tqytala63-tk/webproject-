<?php
session_start();
require 'config.php';

$citizenRequests = [];
$error = "";

// إنشاء رابط ديناميكي للQR code - يعمل على الموبايل أيضاً
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

// الحصول على عنوان الخادم للQR codes
function getServerUrl() {
    global $server_url;
    
    // إذا كان هناك إعداد يدوي في config.php، استخدمه
    if (!empty($server_url)) {
        return $server_url;
    }
    
    // محاولة الحصول على IP من $_SERVER
    if (!empty($_SERVER['SERVER_ADDR'])) {
        $ip = $_SERVER['SERVER_ADDR'];
        // إذا كان 127.0.0.1 أو ::1، نحاول الحصول على IP الحقيقي
        if ($ip === '127.0.0.1' || $ip === '::1') {
            // محاولة الحصول على IP الحقيقي من الشبكة
            $hostname = gethostname();
            $localIP = gethostbyname($hostname);
            if ($localIP !== $hostname && $localIP !== '127.0.0.1') {
                return $localIP;
            }
        } else {
            return $ip;
        }
    }
    
    // إذا فشل، نستخدم HTTP_HOST
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    if ($host === 'localhost' || $host === '127.0.0.1') {
        // محاولة الحصول على IP الحقيقي
        $hostname = gethostname();
        $localIP = gethostbyname($hostname);
        if ($localIP !== $hostname && $localIP !== '127.0.0.1') {
            return $localIP;
        }
    }
    return $host;
}

$host = getServerUrl();
$basePath = dirname($_SERVER['SCRIPT_NAME']);
// إزالة المسار إذا كان root
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}
// التأكد من أن المسار يبدأ بـ / إذا لم يكن فارغاً
if (!empty($basePath) && $basePath[0] !== '/') {
    $basePath = '/' . $basePath;
}
$baseUrl = $protocol . '://' . $host . $basePath;

if(isset($_POST['nationalID'])){
    $nationalID = $_POST['nationalID'];

    // تحقق من وجود المواطن
    $stmt = $pdo->prepare("SELECT * FROM Citizens WHERE NationalID = ?");
    $stmt->execute([$nationalID]);
    $citizen = $stmt->fetch(PDO::FETCH_ASSOC);

    if($citizen){
        // جلب الطلبات حسب الرقم الوطني (UserID) - من نفس الجدول المستخدم في الداشبورد
        $stmt2 = $pdo->prepare("
            SELECT RequestID, TransactionType, Status, RequestDate
            FROM Requests
            WHERE UserID = ?
            ORDER BY RequestDate DESC
        ");
        $stmt2->execute([$nationalID]);
        $citizenRequests = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error = "هذا الرقم الوطني غير موجود!";
    }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>الطلبات حسب الرقم الوطني</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body { margin:0; font-family:'Cairo',sans-serif; background:#f7fafc; color:#0b1220; }
.container { max-width:900px; margin:50px auto; padding:20px; }
h1 { text-align:center; color:#0A7075; margin-bottom:30px; }
form { display:flex; justify-content:center; margin-bottom:30px; }
input[type=text] { padding:10px; font-size:16px; width:300px; border:1px solid #ccc; border-radius:6px; margin-right:10px; }
button { padding:10px 20px; background:#0A7075; color:white; border:none; border-radius:6px; cursor:pointer; transition:0.3s; }
button:hover { background:#095d62; }
.error { text-align:center; color:red; font-weight:bold; margin-bottom:20px; }
.requests-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px; }
.request-card { background:white; padding:20px; border-radius:12px; box-shadow:0 4px 15px rgba(10,112,117,0.1); transition:0.3s; }
.request-card:hover { transform:translateY(-5px); }
.request-card h3 { color:#0A7075; margin-bottom:10px; }
.request-card p { margin:5px 0; font-weight:600; }
.qr-code { text-align:center; margin-top:15px; }
.qr-code img { width:120px; border:2px solid #0A7075; border-radius:8px; padding:5px; background:white; }
.container {
    max-width:900px;
    margin:100px auto 50px auto; /* بدل 50px صارت 90px لتحت */
    padding:20px;
}

</style>
</head>
<body>
    <?php include 'navbar.php'; ?>

<div class="container">
    <h1>الطلبات حسب الرقم الوطني</h1>

    <form id="nationalForm" method="POST">
        <input type="text" name="nationalID" placeholder="أدخل الرقم الوطني" required>
        <button type="submit">عرض الطلبات</button>
    </form>

    <div id="errorMsg" class="error"><?= $error ?></div>

    <div id="requestsContainer" class="requests-grid">
        <?php foreach($citizenRequests as $req): ?>
            <div class="request-card">

                <h3><?= $req['TransactionType'] ?></h3>
                <p>تاريخ الطلب: <?= $req['RequestDate'] ?></p>
                <p style="color:#666; font-size:14px; margin-top:10px;">امسح QR Code لمعرفة حالة الطلب</p>

                <div class="qr-code">
                    <?php 
                    // إنشاء الرابط بشكل صحيح
                   $qrUrl = $protocol . "://" . "192.168.1.8" . dirname($_SERVER['PHP_SELF']) . "/check_request.php?id=" . $req['RequestID'];

                    ?>
                    <img 
                        src="generate_qr.php?data=<?= urlencode($qrUrl) ?>" 
                        alt="QR Code"
                        title="امسح هذا QR Code لمعرفة حالة الطلب">
                    <p style="font-size:11px; color:#999; margin-top:5px;">ID: <?= $req['RequestID'] ?></p>
                    
                    <p style="font-size:10px; color:#0A7075; margin-top:5px;">
                        <a href="<?= htmlspecialchars($qrUrl) ?>" target="_blank" style="color:#0A7075;">افتح الرابط للاختبار</a>
                    </p>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>


</body>
</html>
