<?php
session_start();
require 'config.php';

// جلب الإحصاءات
function getCounts($pdo){
    $total = $pdo->query("SELECT COUNT(*) FROM Requests")->fetchColumn();
    $processing = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='قيد المعالجة'")->fetchColumn();
    $approved = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='مقبول'")->fetchColumn();
    $rejected = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='مرفوض'")->fetchColumn();
    $completed = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='منجز'")->fetchColumn();

    $types = ['إخراج قيد فردي','إخراج قيد عائلي','بطاقة الهوية','وثيقة ولادة','وثيقة وفاة','وثيقة زواج'];
    $typeCounts = [];
    foreach($types as $type){
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Requests WHERE TransactionType = ?");
        $stmt->execute([$type]);
        $typeCounts[$type] = $stmt->fetchColumn();
    }

    return [
        'total'=>$total,
        'processing'=>$processing,
        'approved'=>$approved,
        'rejected'=>$rejected,
        'completed'=>$completed,
        'types'=>$typeCounts
    ];
}

$counts = getCounts($pdo);
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>لوحة التحكم</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { margin:0; font-family:'Cairo',sans-serif; background:#f8fafb; color:#0b1220; display:flex; min-height:100vh; }
.sidebar { width:250px; background:#0A7075; color:white; display:flex; flex-direction:column; padding:25px 0; position:fixed; height:100vh; }
.sidebar h2 { text-align:center; margin-bottom:40px; font-size:22px; }
.sidebar a { color:white; text-decoration:none; padding:14px 25px; display:block; transition:0.3s; font-size:16px; }
.sidebar a:hover, .sidebar a.active { background:#095d62; }
.main { margin-right:250px; padding:40px; flex-grow:1; }
h1 { color:#0A7075; margin-bottom:40px; font-weight:800; text-align:center; }
.stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:25px; }
.card { background:white; border-radius:18px; padding:25px; box-shadow:0 6px 20px rgba(10,112,117,0.12); text-align:center; transition:0.3s; }
.card:hover { transform:translateY(-6px); }
.card i { font-size:34px; color:#0A7075; margin-bottom:10px; }
.card h3 { margin:10px 0; font-size:20px; font-weight:700; color:#0A7075; }
.card p { font-size:18px; font-weight:800; color:#333; }
.card a { text-decoration:none; color:#0A7075; font-weight:600; }
</style>
</head>
<body>

<aside class="sidebar">
  <h2>لوحة التحكم</h2>
  <a href="dashboard.php" class="active"><i class="fa-solid fa-chart-line"></i> الإحصاءات</a>
  <a href="./request.php"><i class="fa-solid fa-list"></i> الطلبات</a>
  <a href="users.php"><i class="fa-solid fa-users"></i> المستخدمين</a>
  <a href="complaints.php"><i class="fa-solid fa-comment-dots"></i> الشكاوى</a>

  <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a>
</aside>

<main class="main">
  <h1>إحصاءات الطلبات</h1>
  <div class="stats">
    <div class="card"><i class="fa-solid fa-layer-group"></i><h3>كل الطلبات</h3><p id="totalCount"><?= $counts['total'] ?></p></div>
    <div class="card"><i class="fa-solid fa-hourglass-half"></i><h3>قيد المعالجة</h3><p id="processingCount"><?= $counts['processing'] ?></p></div>
    <div class="card"><i class="fa-solid fa-circle-check"></i><h3>مقبول</h3><p id="approvedCount"><?= $counts['approved'] ?></p></div>
    <div class="card"><i class="fa-solid fa-circle-xmark"></i><h3>مرفوض</h3><p id="rejectedCount"><?= $counts['rejected'] ?></p></div>
    <div class="card"><i class="fa-solid fa-check-double"></i><h3>منجز</h3><p id="completedCount"><?= $counts['completed'] ?></p></div>
    <div class="card"><i class="fa-solid fa-list"></i><h3>الطلبات</h3><p><a href="./request.php">عرض الطلبات</a></p></div>
  </div>

  <h1 style="margin-top:60px;">الإحصاءات حسب نوع المعاملة</h1>
  <div class="stats">
    <?php foreach ($counts['types'] as $type => $count): ?>
      <div class="card">
        <i class="fa-solid fa-file"></i>
        <h3><?= htmlspecialchars($type) ?></h3>
        <p id="type_<?= str_replace(' ', '_', $type) ?>"><?= $count ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<script>
function updateDashboardCounts(){
    fetch('get_counts.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalCount').textContent = data.total;
        document.getElementById('processingCount').textContent = data.processing;
        document.getElementById('approvedCount').textContent = data.approved;
        document.getElementById('rejectedCount').textContent = data.rejected;
        document.getElementById('completedCount').textContent = data.completed;
        for(let type in data.types){
            let id = 'type_' + type.replace(/ /g, '_');
            let el = document.getElementById(id);
            if(el) el.textContent = data.types[type];
        }
    });
}
</script>

</body>
</html>
