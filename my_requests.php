<?php
session_start();
require 'config.php';


$userID = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT r.RequestID, r.TransactionType, r.Status, r.RequestDate, r.QRCode
                       FROM Requests r
                       WHERE r.UserID = ?
                       ORDER BY r.RequestDate DESC");
$stmt->execute([$userID]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>طلباتي</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<style>
/* نفس CSS تبع index page مع تعديلات بسيطة */
* {margin:0;padding:0;box-sizing:border-box;font-family:'Cairo',sans-serif;}
:root {--bg:#f7fafc;--accent:#0A7075;--card-bg:#fff;--card-border:rgba(10,112,117,0.08);}
body {background:var(--bg);color:#0b1220;padding:50px 20px;}
h2 {text-align:center;margin-bottom:50px;color:var(--accent);font-size:36px;}
.requests-grid {display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px;max-width:1200px;margin:0 auto;}
.request-card {background:var(--card-bg);border-radius:18px;padding:25px 20px;text-align:center;color:#0b1220;border:1px solid var(--card-border);box-shadow:0 5px 15px rgba(10,112,117,0.08);transition:all 0.3s ease;}
.request-card:hover {transform:translateY(-8px);box-shadow:0 20px 40px rgba(10,112,117,0.15);border-color:var(--accent);}
.request-card h4 {margin:15px 0 10px;font-size:20px;font-weight:700;color:var(--accent);}
.request-card p {color:#555;font-size:14px;line-height:1.6;margin:5px 0;}
.request-card img {margin-top:15px;border-radius:10px;}
</style>
</head>
<body>

<h2>طلباتي</h2>
<div class="requests-grid">
<?php foreach($requests as $req): ?>
  <div class="request-card">
    <?php
        $icon = 'fa-file-lines';
        switch($req['TransactionType']){
            case 'BirthExtract': $icon='fa-user'; break;
            case 'FamilyExtract': $icon='fa-users'; break;
            case 'IDCard': $icon='fa-id-card'; break;
            case 'BirthCertificate': $icon='fa-file-lines'; break;
            case 'DeathCertificate': $icon='fa-file-circle-xmark'; break;
            case 'MarriageCertificate': $icon='fa-ring'; break;
        }
    ?>
    <i class="fa-solid <?= $icon ?>" style="font-size:28px;color:var(--accent);"></i>
    <h4><?= htmlspecialchars($req['TransactionType']) ?></h4>
    <p><strong>الحالة:</strong> <?= htmlspecialchars($req['Status']) ?></p>
    <p><strong>تاريخ الطلب:</strong> <?= htmlspecialchars($req['RequestDate']) ?></p>
    <?php if($req['QRCode']): ?>
        <img src="<?= htmlspecialchars($req['QRCode']) ?>" alt="QR Code" width="120">
    <?php else: ?>
        <p>QR Code غير متوفر بعد</p>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
</div>

</body>
</html>
