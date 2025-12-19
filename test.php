<?php
require 'config.php';

$requestID = $_GET['id'] ?? null;

if (!$requestID) die("طلب غير صالح!");

// جلب بيانات الطلب وحالة الطلب مع بيانات المواطن
$stmt = $pdo->prepare("
    SELECT r.Status, c.*
    FROM Requests r
    JOIN Citizens c ON r.UserID = c.NationalID
    WHERE r.RequestID = ?
");
$stmt->execute([$requestID]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) die("الطلب غير موجود!");

$status = $data['Status'];
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>حالة الطلب</title>
</head>
<body>
<h1>حالة الطلب: <?= htmlspecialchars($status) ?></h1>

<?php if ($status === 'مقبول'): ?>
    <p>يمكنك تنزيل نموذج البطاقة:</p>
    <form action="download_form.php" method="POST">
        <input type="hidden" name="nationalID" value="<?= htmlspecialchars($data['NationalID']) ?>">
        <button type="submit">Download PDF</button>
    </form>
<?php else: ?>
    <p>لا يمكنك تنزيل النموذج إلا بعد قبول الطلب.</p>
<?php endif; ?>

</body>
</html>
