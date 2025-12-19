<?php 
session_start();
require 'config.php';

// جلب المستخدمين من جدول Citizens
$stmt = $pdo->query("SELECT CitizenID, NationalID, FirstName, LastName, Phone, Email, Governorate, District, CreatedAt FROM Citizens ORDER BY CreatedAt DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>إدارة المستخدمين</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {margin:0;font-family:'Cairo',sans-serif;background:#f8fafb;color:#0b1220;display:flex;min-height:100vh;}
    .sidebar {width:250px;background:#0A7075;color:white;display:flex;flex-direction:column;padding:25px 0;position:fixed;height:100vh;}
    .sidebar h2{text-align:center;margin-bottom:40px;font-size:22px;}
    .sidebar a{color:white;text-decoration:none;padding:14px 25px;display:block;transition:0.3s;font-size:16px;}
    .sidebar a:hover,.sidebar a.active{background:#095d62;}
    .main{margin-right:250px;padding:40px;flex-grow:1;}
    h1{color:#0A7075;margin-bottom:30px;font-weight:800;text-align:center;}
    table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0 6px 15px rgba(10,112,117,0.08);}
    table th,td{padding:12px;text-align:center;border-bottom:1px solid #eee;}
    table th{background:#0A7075;color:white;}
    tr:hover{background:#f1f7f7;}
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2>لوحة التحكم</h2>
    <a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> الإحصاءات</a>
    <a href="request.php"><i class="fa-solid fa-list"></i> الطلبات</a>
    <a href="users.php" class="active"><i class="fa-solid fa-users"></i> المستخدمين</a>
    <a href="complaints.php"><i class="fa-solid fa-comment-dots"></i> الشكاوى</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a>
  </aside>

  <main class="main">
    <h1>قائمة المستخدمين</h1>

    <!-- ********* Search Box ********* -->
    <!-- مربع البحث -->
<div style="margin-bottom: 20px; text-align: center;">
    <input 
        type="text" 
        id="searchInput" 
        placeholder="ابحث حسب الاسم أو نوع المعاملة أو الحالة..." 
        style="width: 60%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; font-size: 16px;">
</div>


    <table>
      <thead>
        <tr>
          <th>الرقم الوطني</th>
          <th>الاسم الكامل</th>
          <th>الهاتف</th>
          <th>الإيميل</th>
          <th>المحافظة</th>
          <th>المنطقة</th>
          <th>تاريخ التسجيل</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach($users as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['NationalID']) ?></td>
            <td><?= htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']) ?></td>
            <td><?= htmlspecialchars($user['Phone']) ?></td>
            <td><?= htmlspecialchars($user['Email']) ?></td>
            <td><?= htmlspecialchars($user['Governorate']) ?></td>
            <td><?= htmlspecialchars($user['District']) ?></td>
            <td><?= $user['CreatedAt'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </main>

  <!-- ********* Search Filter Script ********* -->
  <script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(searchValue) ? "" : "none";
        });
    });
  </script>

</body>
</html>
