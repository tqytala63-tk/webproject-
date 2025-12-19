<?php
// صفحة للتحقق من حالة الخادم
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فحص حالة الخادم</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .info { background: white; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .info h3 { color: #0A7075; }
        .success { background: #d4edda; border: 1px solid #28a745; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 5px; margin: 10px 0; }
        code { background: #f0f0f0; padding: 5px 10px; border-radius: 5px; display: block; margin: 10px 0; word-break: break-all; }
        .steps { background: white; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .steps ol { margin: 10px 0; padding-right: 20px; }
        .steps li { margin: 8px 0; }
    </style>
</head>
<body>
    <h1>فحص حالة الخادم والاتصال</h1>
    
    <div class="info">
        <h3>معلومات الخادم:</h3>
        <p><strong>SERVER_ADDR:</strong> <code><?= $_SERVER['SERVER_ADDR'] ?? 'غير محدد' ?></code></p>
        <p><strong>HTTP_HOST:</strong> <code><?= $_SERVER['HTTP_HOST'] ?? 'غير محدد' ?></code></p>
        <p><strong>SERVER_PORT:</strong> <code><?= $_SERVER['SERVER_PORT'] ?? '80' ?></code></p>
        <p><strong>REMOTE_ADDR:</strong> <code><?= $_SERVER['REMOTE_ADDR'] ?? 'غير محدد' ?></code></p>
    </div>
    
    <?php
    // فحص إذا كان PHP يعمل
    echo '<div class="success">';
    echo '<h3>✅ PHP يعمل بشكل صحيح</h3>';
    echo '<p>الخادم يستجيب لطلبات PHP</p>';
    echo '</div>';
    
    // فحص قاعدة البيانات
    try {
        require 'config.php';
        $pdo->query("SELECT 1");
        echo '<div class="success">';
        echo '<h3>✅ قاعدة البيانات متصلة</h3>';
        echo '<p>الاتصال بقاعدة البيانات يعمل بشكل صحيح</p>';
        echo '</div>';
    } catch(Exception $e) {
        echo '<div class="error">';
        echo '<h3>❌ مشكلة في قاعدة البيانات</h3>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '</div>';
    }
    
    // فحص عنوان IP
    $serverAddr = $_SERVER['SERVER_ADDR'] ?? '';
    if($serverAddr === '127.0.0.1' || $serverAddr === '::1') {
        echo '<div class="warning">';
        echo '<h3>⚠️ Apache يستمع على localhost فقط</h3>';
        echo '<p>Apache يستمع على 127.0.0.1 - قد لا يعمل من الموبايل</p>';
        echo '</div>';
    } else {
        echo '<div class="success">';
        echo '<h3>✅ Apache يستمع على IP حقيقي</h3>';
        echo '<p>العنوان: <code>' . htmlspecialchars($serverAddr) . '</code></p>';
        echo '</div>';
    }
    ?>
    
    <div class="error">
        <h3>❌ المشكلة: "Server stopped responding"</h3>
        <p>هذا يعني أن الخادم لا يستجيب. الحلول:</p>
    </div>
    
    <div class="steps">
        <h3>خطوات الحل:</h3>
        <ol>
            <li><strong>تحقق من Apache في XAMPP:</strong>
                <ul>
                    <li>افتح XAMPP Control Panel</li>
                    <li>تأكد أن Apache يعمل (يجب أن يكون اللون أخضر)</li>
                    <li>إذا كان متوقفاً، اضغط "Start"</li>
                </ul>
            </li>
            <li><strong>إعادة تشغيل Apache:</strong>
                <ul>
                    <li>اضغط "Stop" بجانب Apache</li>
                    <li>انتظر 5 ثوان</li>
                    <li>اضغط "Start" مرة أخرى</li>
                </ul>
            </li>
            <li><strong>فحص المنفذ 80:</strong>
                <ul>
                    <li>افتح CMD واكتب: <code>netstat -ano | findstr :80</code></li>
                    <li>إذا كان مشغولاً، قد تحتاج لتغيير المنفذ</li>
                </ul>
            </li>
            <li><strong>إيقاف جدار الحماية مؤقتاً:</strong>
                <ul>
                    <li>افتح Windows Defender Firewall</li>
                    <li>أوقفه مؤقتاً للاختبار</li>
                </ul>
            </li>
            <li><strong>فحص إعدادات Apache:</strong>
                <ul>
                    <li>تأكد أن <code>Listen 0.0.0.0:80</code> في httpd.conf</li>
                    <li>افتح <a href="check_apache.php">check_apache.php</a> للفحص</li>
                </ul>
            </li>
        </ol>
    </div>
    
    <div class="warning">
        <h3>⚠️ اختبار الاتصال:</h3>
        <p>من الموبايل (على نفس WiFi):</p>
        <code>http://172.21.80.1/senior/check_server.php</code>
        <p style="margin-top: 10px;">إذا ظهرت هذه الصفحة، يعني الاتصال يعمل!</p>
    </div>
    
    <div class="info">
        <h3>معلومات إضافية:</h3>
        <p><strong>عنوان IP في config.php:</strong> <code><?php 
        require 'config.php'; 
        global $server_url; 
        echo htmlspecialchars($server_url ?: 'غير محدد'); 
        ?></code></p>
        <p><strong>الوقت الحالي:</strong> <?= date('Y-m-d H:i:s') ?></p>
    </div>
</body>
</html>

