<?php
// استدعاء مكتبة PHP QR Code
include "phpqrcode/phpqrcode/qrlib.php";

// الحصول على البيانات من URL
$data = isset($_GET['data']) ? $_GET['data'] : '';

// إذا لم تكن هناك بيانات، عرض رسالة خطأ
if(empty($data)){
    header('Content-Type: image/png');
    // إنشاء صورة فارغة أو رسالة خطأ
    $im = imagecreate(200, 200);
    $bg = imagecolorallocate($im, 255, 255, 255);
    $text_color = imagecolorallocate($im, 255, 0, 0);
    imagestring($im, 5, 50, 90, 'No Data', $text_color);
    imagepng($im);
    imagedestroy($im);
    exit;
}

// إعداد رأس الصورة
header('Content-Type: image/png');

// توليد QR Code مباشرة إلى المتصفح
QRcode::png($data, false, 'L', 4, 2);
?>
