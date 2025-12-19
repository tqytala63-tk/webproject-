<?php
session_start();
require 'config.php';
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// جلب كل الشكاوى
$complaints = $pdo->query("SELECT * FROM Complaints ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>الشكاوى</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { margin:0; font-family:'Cairo',sans-serif; background:#f7fafc; display:flex; min-height:100vh; }
.sidebar { width:250px; background:#0A7075; color:white; display:flex; flex-direction:column; padding:25px 0; position:fixed; height:100vh; }
.sidebar h2 { text-align:center; margin-bottom:40px; font-size:22px; }
.sidebar a { color:white; text-decoration:none; padding:14px 25px; display:block; transition:0.3s; font-size:16px; }
.sidebar a:hover, .sidebar a.active { background:#095d62; }
.main { margin-right:250px; padding:40px; flex-grow:1; }
h1 { text-align:center; color:#0A7075; margin-bottom:30px; }
table { width:100%; border-collapse:collapse; background:white; border-radius:10px; overflow:hidden; box-shadow:0 4px 15px rgba(10,112,117,0.1);}
th, td { padding:12px 15px; text-align:center; border-bottom:1px solid #ddd; }
th { background:#0A7075; color:white; }
tr:hover { background:#f1f1f1; }
#searchContainer { margin-bottom:20px; text-align:center; }
#searchInput { width:60%; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px; }
#clearBtn { padding:10px 15px; margin-right:10px; border:none; border-radius:8px; background:#0A7075; color:white; cursor:pointer; font-size:16px; }
#clearBtn:hover { background:#095d62; }
</style>
</head>
<body>

<aside class="sidebar">
  <h2>لوحة التحكم</h2>
  <a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> الإحصاءات</a>
  <a href="request.php"><i class="fa-solid fa-list"></i> الطلبات</a>
  <a href="complaints.php" class="active"><i class="fa-solid fa-comment-dots"></i> الشكاوى</a>
  <a href="users.php"><i class="fa-solid fa-users"></i> المستخدمين</a>
  <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a>
</aside>

<main class="main">
<h1>جميع الشكاوى</h1>

<!-- Search Box -->
<div id="searchContainer">
    <input type="text" id="searchInput" placeholder="ابحث حسب الاسم أو العنوان أو الرسالة...">
    
</div>

<table id="complaintsTable">
<thead>
<tr>
<th>الاسم</th>
<th>البريد الإلكتروني</th>
<th>العنوان</th>
<th>الرسالة</th>
<th>تاريخ الإرسال</th>
</tr>
</thead>
<tbody>
<?php foreach($complaints as $c): ?>
<tr>
<td><?= htmlspecialchars($c['user_name']) ?></td>
<td><?= htmlspecialchars($c['user_email']) ?></td>
<td><?= htmlspecialchars($c['subject']) ?></td>
<td><?= htmlspecialchars($c['message']) ?></td>
<td><?= htmlspecialchars($c['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</main>

<script>
const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearBtn');
const table = document.getElementById('complaintsTable').getElementsByTagName('tbody')[0];

// البحث المباشر
searchInput.addEventListener('keyup', function() {
    const filter = searchInput.value.toLowerCase();
    const rows = table.getElementsByTagName('tr');
    for(let i=0;i<rows.length;i++){
        const cells = rows[i].getElementsByTagName('td');
        let match=false;
        for(let j=0;j<cells.length;j++){
            if(cells[j].textContent.toLowerCase().includes(filter)){
                match=true;
                break;
            }
        }
        rows[i].style.display = match ? '' : 'none';
    }
});

// زر مسح البحث
clearBtn.addEventListener('click', function(){
    searchInput.value='';
    const rows = table.getElementsByTagName('tr');
    for(let i=0;i<rows.length;i++){
        rows[i].style.display='';
    }
});
</script>

</body>
</html>
