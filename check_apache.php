<?php
// صفحة للتحقق من إعدادات Apache
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فحص إعدادات Apache</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .info { background: white; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .info h3 { color: #0A7075; }
        .success { background: #d4edda; border: 1px solid #28a745; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 5px; margin: 10px 0; }
        code { background: #f0f0f0; padding: 5px 10px; border-radius: 5px; display: block; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>فحص إعدادات Apache للاتصال من الموبايل</h1>
    
    <div class="info">
        <h3>معلومات الخادم:</h3>
        <p><strong>SERVER_ADDR:</strong> <code><?= $_SERVER['SERVER_ADDR'] ?? 'غير محدد' ?></code></p>
        <p><strong>HTTP_HOST:</strong> <code><?= $_SERVER['HTTP_HOST'] ?? 'غير محدد' ?></code></p>
        <p><strong>REMOTE_ADDR:</strong> <code><?= $_SERVER['REMOTE_ADDR'] ?? 'غير محدد' ?></code></p>
    </div>
    
    <?php
    $serverAddr = $_SERVER['SERVER_ADDR'] ?? '';
    
    if($serverAddr === '127.0.0.1' || $serverAddr === '::1') {
        echo '<div class="error">';
        echo '<h3>❌ المشكلة: Apache يستمع على localhost فقط!</h3>';
        echo '<p>Apache يستمع على 127.0.0.1 وهذا يعني أنه لا يقبل الاتصالات من الموبايل.</p>';
        echo '<p><strong>الحل السريع:</strong></p>';
        echo '<ol>';
        echo '<li>افتح XAMPP Control Panel</li>';
        echo '<li>اضغط "Config" بجانب Apache</li>';
        echo '<li>اختر "httpd.conf"</li>';
        echo '<li>ابحث عن: <code>Listen 80</code> أو <code>Listen 127.0.0.1:80</code></li>';
        echo '<li><strong>غيره إلى: <code>Listen 0.0.0.0:80</code></strong></li>';
        echo '<li>احفظ الملف (Ctrl+S)</li>';
        echo '<li>أعد تشغيل Apache (Stop ثم Start)</li>';
        echo '</ol>';
        echo '<p><strong>ملف الإعدادات:</strong> <code>C:\\xampp\\apache\\conf\\httpd.conf</code></p>';
        echo '</div>';
    } else {
        echo '<div class="success">';
        echo '<h3>✅ Apache يستمع على جميع الواجهات</h3>';
        echo '<p>Apache يستمع على: <code>' . htmlspecialchars($serverAddr) . '</code></p>';
        echo '<p>هذا يعني أنه يجب أن يقبل الاتصالات من الموبايل.</p>';
        echo '</div>';
    }
    ?>
    
    <div class="warning">
        <h3>⚠️ خطوات إضافية للتحقق:</h3>
        <ol>
            <li>تأكد أن الموبايل والكمبيوتر على نفس شبكة WiFi</li>
            <li>افتح من الموبايل: <code>http://172.21.80.1/senior/test_mobile.php</code></li>
            <li>إذا لم يعمل، أوقف جدار الحماية مؤقتاً</li>
            <li>تأكد أن Apache يعمل في XAMPP</li>
        </ol>
    </div>
    
    <div class="info">
        <h3>اختبار الاتصال:</h3>
        <p>من الموبايل، افتح:</p>
        <code>http://172.21.80.1/senior/test_mobile.php</code>
        <p style="margin-top: 10px;">إذا ظهرت الصفحة، يعني الاتصال يعمل!</p>
    </div>
</body>
</html>

