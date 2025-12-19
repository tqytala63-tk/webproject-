<?php
require 'config.php';

// صفحة لفحص QR code والرابط
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

function getServerUrl() {
    global $server_url;
    if (!empty($server_url)) {
        return $server_url;
    }
    if (!empty($_SERVER['SERVER_ADDR'])) {
        $ip = $_SERVER['SERVER_ADDR'];
        if ($ip === '127.0.0.1' || $ip === '::1') {
            $hostname = gethostname();
            $localIP = gethostbyname($hostname);
            if ($localIP !== $hostname && $localIP !== '127.0.0.1') {
                return $localIP;
            }
        } else {
            return $ip;
        }
    }
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    if ($host === 'localhost' || $host === '127.0.0.1') {
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
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}
if (!empty($basePath) && $basePath[0] !== '/') {
    $basePath = '/' . $basePath;
}

// جلب طلب للاختبار
$testRequest = $pdo->query("SELECT RequestID FROM Requests LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$testID = $testRequest ? $testRequest['RequestID'] : 1;

$checkRequestPath = $basePath . '/check_request.php';
$checkRequestPath = str_replace('//', '/', $checkRequestPath);
$testUrl = $protocol . '://' . $host . $checkRequestPath . '?id=' . $testID;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>فحص QR Code</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .info { background: white; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .info h3 { color: #0A7075; }
        code { background: #f0f0f0; padding: 10px; border-radius: 5px; display: block; margin: 10px 0; word-break: break-all; font-size: 14px; }
        .error { background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .success { background: #d4edda; border: 1px solid #28a745; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .test-link { background: #0A7075; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0; }
        .qr-box { text-align: center; padding: 20px; background: white; border-radius: 10px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>فحص QR Code والرابط</h1>
    
    <div class="info">
        <h3>معلومات الخادم:</h3>
        <p><strong>عنوان IP:</strong> <code><?= htmlspecialchars($host) ?></code></p>
        <p><strong>المسار:</strong> <code><?= htmlspecialchars($basePath) ?></code></p>
        <p><strong>البروتوكول:</strong> <code><?= $protocol ?></code></p>
        <p><strong>مسار check_request.php:</strong> <code><?= htmlspecialchars($checkRequestPath) ?></code></p>
    </div>
    
    <div class="info">
        <h3>الرابط في QR Code:</h3>
        <code><?= htmlspecialchars($testUrl) ?></code>
        <br>
        <a href="<?= htmlspecialchars($testUrl) ?>" class="test-link" target="_blank">افتح الرابط للاختبار</a>
    </div>
    
    <?php
    // فحص إذا كان الرابط يحتوي على localhost
    if (strpos($testUrl, 'localhost') !== false || strpos($testUrl, '127.0.0.1') !== false) {
        echo '<div class="error">';
        echo '<h3>❌ المشكلة: الرابط يحتوي على localhost!</h3>';
        echo '<p>الرابط يحتوي على localhost أو 127.0.0.1 وهذا لن يعمل من الموبايل.</p>';
        echo '<p><strong>الحل:</strong></p>';
        echo '<ol>';
        echo '<li>افتح config.php</li>';
        echo '<li>تأكد أن $server_url يحتوي على عنوان IP (مثال: \'172.21.80.1\')</li>';
        echo '<li>أعد تحميل هذه الصفحة</li>';
        echo '</ol>';
        echo '</div>';
    } else {
        echo '<div class="success">';
        echo '<h3>✅ الرابط لا يحتوي على localhost</h3>';
        echo '<p>الرابط يستخدم عنوان IP: <code>' . htmlspecialchars($host) . '</code></p>';
        echo '</div>';
    }
    
    // اختبار الاتصال
    $testResult = @file_get_contents($testUrl, false, stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET'
        ]
    ]));
    
    if($testResult === false) {
        echo '<div class="warning">';
        echo '<h3>⚠️ تحذير: الرابط قد لا يعمل</h3>';
        echo '<p>لا يمكن الوصول للرابط من هذا الجهاز. تأكد من:</p>';
        echo '<ul>';
        echo '<li>Apache يعمل في XAMPP</li>';
        echo '<li>الموبايل والكمبيوتر على نفس شبكة WiFi</li>';
        echo '<li>افتح الرابط مباشرة من الموبايل للاختبار</li>';
        echo '</ul>';
        echo '</div>';
    } else {
        echo '<div class="success">';
        echo '<h3>✅ الرابط يعمل!</h3>';
        echo '<p>يمكنك مسح QR code من الموبايل</p>';
        echo '</div>';
    }
    ?>
    
    <div class="qr-box">
        <h3>QR Code للاختبار:</h3>
        <img src="generate_qr.php?data=<?= urlencode($testUrl) ?>" alt="QR Code" style="border: 3px solid #0A7075; padding: 10px; background: white; max-width: 300px;">
        <p style="margin-top: 10px; color: #666;">امسح هذا QR code من الموبايل</p>
    </div>
    
    <div class="warning">
        <h3>⚠️ خطوات الحل إذا لم يعمل:</h3>
        <ol>
            <li>افتح <code>config.php</code> وتأكد أن <code>$server_url = '172.21.80.1';</code></li>
            <li>تأكد أن Apache يستمع على <code>0.0.0.0:80</code> (افتح check_apache.php)</li>
            <li>تأكد أن الموبايل والكمبيوتر على نفس شبكة WiFi</li>
            <li>افتح الرابط مباشرة من الموبايل: <code><?= htmlspecialchars($testUrl) ?></code></li>
        </ol>
    </div>
</body>
</html>

