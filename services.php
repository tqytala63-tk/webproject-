<?php
require 'config.php';
?>
<!doctype html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>الخدمات</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
  <h2>الخدمات المتاحة</h2>
  <div class="services-grid">
    <?php
    // نعرض أنواع المعاملات من RequiredDocuments (مجموعات)
    $stmt = $pdo->query("SELECT DISTINCT TransactionType FROM RequiredDocuments");
    $types = $stmt->fetchAll();
    if ($types) {
      foreach ($types as $t) {
        echo '<div class="card">';
        echo '<h4>' . htmlspecialchars($t['TransactionType']) . '</h4>';
        // عرض المستندات المطلوبة
        $s = $pdo->prepare("SELECT DocumentName FROM RequiredDocuments WHERE TransactionType = ?");
        $s->execute([$t['TransactionType']]);
        $docs = $s->fetchAll();
        echo '<ul>';
        foreach ($docs as $d) echo '<li>' . htmlspecialchars($d['DocumentName']) . '</li>';
        echo '</ul>';
        echo '<a class="btn btn-primary" href="request_service.php?type=' . urlencode($t['TransactionType']) . '">اطلب الخدمة</a>';
        echo '</div>';
      }
    } else {
      echo '<div class="card">لا توجد خدمات مسجلة.</div>';
    }
    ?>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
