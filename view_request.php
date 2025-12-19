<?php
// view_request.php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    echo "طلب غير موجود";
    exit;
}

// جلب بيانات الطلب من جدول Requests
$stmt = $pdo->prepare("SELECT r.*, u.FullName, u.Email FROM Requests r LEFT JOIN Users u ON r.UserID = u.UserID WHERE r.RequestID = ?");
$stmt->execute([$id]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$r) {
    echo "طلب غير موجود";
    exit;
}

// تحميل تفاصيل الطلب من الجدول الخاص حسب TransactionType
$detail = null;
$type = $r['TransactionType'];
$ref = (int)$r['TransactionRefID'];

switch ($type) {
    case 'إخراج قيد عائلي':
        $s = $pdo->prepare("SELECT * FROM FamilyExtract WHERE FamilyExtractID = ?");
        $s->execute([$ref]);
        $detail = $s->fetch(PDO::FETCH_ASSOC);
        break;
    case 'إخراج قيد فردي':
        $s = $pdo->prepare("SELECT * FROM BirthExtract WHERE ExtractID = ?");
        $s->execute([$ref]);
        $detail = $s->fetch(PDO::FETCH_ASSOC);
        break;
    case 'وثيقة ولادة':
        $s = $pdo->prepare("SELECT * FROM BirthCertificate WHERE CertificateID = ?");
        $s->execute([$ref]);
        $detail = $s->fetch(PDO::FETCH_ASSOC);
        break;
    case 'وثيقة وفاة':
        $s = $pdo->prepare("SELECT * FROM DeathCertificate WHERE DeathID = ?");
        $s->execute([$ref]);
        $detail = $s->fetch(PDO::FETCH_ASSOC);
        break;
    case 'وثيقة زواج':
        $s = $pdo->prepare("SELECT * FROM MarriageCertificate WHERE MarriageID = ?");
        $s->execute([$ref]);
        $detail = $s->fetch(PDO::FETCH_ASSOC);
        break;
    case 'بطاقة الهوية':
        $s = $pdo->prepare("SELECT * FROM IDCard WHERE CardID = ?");
        $s->execute([$ref]);
        $detail = $s->fetch(PDO::FETCH_ASSOC);
        break;
    default:
        $detail = null;
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>عرض الطلب</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
<style>body{font-family:'Cairo',sans-serif;padding:20px;background:#f4f8f9}.card{background:#fff;padding:16px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}</style>
</head>
<body>
<div class="card">
  <h2>تفاصيل الطلب #<?= htmlspecialchars($r['RequestID']) ?></h2>
  <p><strong>المستخدم:</strong> <?= htmlspecialchars($r['FullName'] ?? $r['UserID']) ?> (<?= htmlspecialchars($r['Email'] ?? '') ?>)</p>
  <p><strong>الخدمة:</strong> <?= htmlspecialchars($r['TransactionType']) ?></p>
  <p><strong>حالة الطلب:</strong> <?= htmlspecialchars($r['Status']) ?></p>
  <p><strong>تاريخ الطلب:</strong> <?= htmlspecialchars($r['RequestDate']) ?></p>

  <hr>
  <h3>تفاصيل المرتبطة</h3>
  <?php if (!$detail): ?>
    <p class="small-muted">لا توجد تفاصيل إضافية لهذا الطلب.</p>
  <?php else: ?>
    <pre><?= htmlspecialchars(print_r($detail, true)) ?></pre>
  <?php endif; ?>

  <p><a href="./dashboard.php">رجوع للوحة التحكم</a></p>
</div>
</body>
</html>
