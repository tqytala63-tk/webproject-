<?php
require 'config.php';
$nationalID = $_POST['nationalID'] ?? null;
if (!$nationalID) die("رقم غير صالح!");

$stmt = $pdo->prepare("SELECT * FROM Citizens WHERE NationalID = ?");
$stmt->execute([$nationalID]);
$citizen = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$citizen) die("المواطن غير موجود!");

// إعداد headers للتحميل كـ HTML
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="id_card_'.$citizen['NationalID'].'.html"');

?>

<!doctype html>
<html lang="ar" dir="rtl">
<head><meta charset="utf-8"><title>بطاقة الهوية</title></head>
<body>
<h1>بطاقة هوية</h1>
<p>الاسم: <?= htmlspecialchars($citizen['FirstName']) ?></p>
<p>الشهرة: <?= htmlspecialchars($citizen['LastName']) ?></p>
<p>اسم الأب: <?= htmlspecialchars($citizen['FatherName']) ?></p>
<p>اسم الأم: <?= htmlspecialchars($citizen['MotherName']) ?></p>
<p>تاريخ الولادة: <?= htmlspecialchars($citizen['BirthDate']) ?></p>
<p>مكان الولادة: <?= htmlspecialchars($citizen['BirthPlace']) ?></p>
<p>رقم الهوية: <?= htmlspecialchars($citizen['NationalID']) ?></p>
</body>
</html>
