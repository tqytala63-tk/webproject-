<?php
session_start();
require 'config.php';
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// جلب الطلبات مع الاسم الكامل للمواطن
$requests = $pdo->query("
    SELECT r.RequestID, r.UserID, r.TransactionType, r.Status, r.RequestDate, 
           CONCAT(c.FirstName,' ',c.LastName) AS CitizenName
    FROM Requests r
    LEFT JOIN citizens c ON r.UserID = c.NationalID
    ORDER BY r.RequestDate DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>الطلبات</title>
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
button { padding:6px 12px; border:none; border-radius:6px; cursor:pointer; color:white; margin:2px; }
.accept { background:#28a745; }
.reject { background:#dc3545; }
.complete { background:#007bff; }
.status { font-weight:700; }
</style>
</head>
<body>

<aside class="sidebar">
  <h2>لوحة التحكم</h2>
  <a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> الإحصاءات</a>
  <a href="./request.php" class="active"><i class="fa-solid fa-list"></i> الطلبات</a>
  <a href="users.php"><i class="fa-solid fa-users"></i> المستخدمين</a>
  <a href="complaints.php"><i class="fa-solid fa-comment-dots"></i> الشكاوى</a>
  <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a>
</aside>

<main class="main">
<h1>الطلبات</h1>

<?php
// عرض alert إذا فيه رسالة في session
if(isset($_SESSION['message'])){
    $msg = $_SESSION['message'];
    echo "<script>alert('".addslashes($msg)."');</script>";
    unset($_SESSION['message']); // مسح الرسالة بعد عرضها مرة واحدة
}
?>


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
<th>رقم الطلب</th>
<th>المواطن</th>
<th>نوع المعاملة</th>
<th>الحالة</th>
<th>تاريخ الطلب</th>
<?php if($isAdmin) echo "<th>إدارة</th>"; ?>
</tr>
</thead>
<tbody>
<?php foreach($requests as $req): ?>
<tr id="row-<?= $req['RequestID'] ?>">
<td><?= $req['RequestID'] ?></td>
<td><?= htmlspecialchars($req['CitizenName'] ?: 'غير معروف') ?></td>
<td><?= htmlspecialchars($req['TransactionType']) ?></td>
<td class="status"><?= $req['Status'] ?></td>
<td><?= $req['RequestDate'] ?></td>
<?php if($isAdmin): ?>
<td>
<button class="accept" onclick="updateStatus(<?= $req['RequestID'] ?>,'مقبول')">قبول</button>
<button class="reject" onclick="updateStatus(<?= $req['RequestID'] ?>,'مرفوض')">رفض</button>
<button class="complete" onclick="updateStatus(<?= $req['RequestID'] ?>,'منجز + قيد المتابعة')">منجز</button>
</td>
<?php if($isAdmin && $req['Status'] === 'مقبول'): ?>
<td>
    <a href="open_form.php?requestID=<?= $req['RequestID'] ?>" class="accept"></a>
</td>
<?php endif; ?>

<?php endif; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</main>

<script>
// البحث داخل الجدول
document.getElementById("searchInput").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? "" : "none";
    });
});
</script>


<script>
function updateStatus(requestID, status){
    fetch('update_request.php', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:requestID,status:status})
    }).then(res=>res.json())
    .then(data=>{
        if(data.success){
            const row = document.querySelector("#row-"+requestID);
            row.querySelector(".status").textContent = status;

            // إذا صار مقبول، افتح الفورم مباشرة
            if(status === 'مقبول'){
                window.open(`open_form.php?requestID=${requestID}`, '_blank');
            }

            // تحديث الـ dashboard فورياً
            fetch('get_counts.php')
            .then(res=>res.json())
            .then(c=>{
                window.dispatchEvent(new CustomEvent('dashboardUpdate', {detail:c}));
            });

            alert("تم تحديث الحالة بنجاح!");
        }else{
            alert("حدث خطأ، حاول مرة أخرى.");
        }
    });
}

</script>

</body>
</html>
