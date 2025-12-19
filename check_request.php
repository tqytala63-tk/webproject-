<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';

if(!isset($_GET['id']) || empty($_GET['id'])){
    die("Request ID not provided");
}

$requestID = intval($_GET['id']);
if($requestID <= 0){
    die("Invalid Request ID");
}

// جلب الطلب
$stmt = $pdo->prepare("SELECT * FROM Requests WHERE RequestID = ?");
$stmt->execute([$requestID]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$request){
    die("Request not found");
}

// جلب اسم المواطن
$citizenName = "غير معروف";
if(!empty($request['UserID'])){
    $stmt2 = $pdo->prepare("SELECT FirstName, LastName FROM Citizens WHERE NationalID = ?");
    $stmt2->execute([$request['UserID']]);
    if($c = $stmt2->fetch()){
        $citizenName = $c['FirstName']." ".$c['LastName'];
    }
}

// لون الحالة
$statusColor = '#666';
if($request['Status']=='مقبول') $statusColor='#28a745';
elseif($request['Status']=='مرفوض') $statusColor='#dc3545';
elseif(str_contains($request['Status'],'منجز')) $statusColor='#007bff';
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>حالة الطلب</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Cairo',sans-serif;
    background:#0A7075;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}
.container{
    width:600px;
    background:white;
    border-radius:18px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
    overflow:hidden;
}
.header{
    background:#0A7075;
    color:white;
    padding:30px;
    text-align:center;
}
.content{ padding:30px; }
.row{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #eee;
}
.badge{
    background:<?= $statusColor ?>;
    color:white;
    padding:6px 18px;
    border-radius:20px;
    font-weight:700;
}
.footer{
    background:#f7fafc;
    padding:20px;
    text-align:center;
    font-size:14px;
    color:#666;
}
.print-btn{
    background:#0A7075;
    color:white;
    padding:12px 25px;
    border-radius:8px;
    font-weight:700;
    text-decoration:none;
    display:inline-block;
    margin-top:25px;
}
@media print{
    .print-btn{ display:none; }
    body{ background:white; }
}
</style>
</head>

<body>

<div id="print">
<div class="container">

<div class="header">
    <h2>حالة الطلب</h2>
    <p>رقم الطلب #<?= $requestID ?></p>
</div>

<div class="content">
    <div class="row"><span>المواطن:</span><strong><?= htmlspecialchars($citizenName) ?></strong></div>
    <div class="row"><span>نوع المعاملة:</span><strong><?= htmlspecialchars($request['TransactionType']) ?></strong></div>
    <div class="row"><span>تاريخ الطلب:</span><strong><?= $request['RequestDate'] ?></strong></div>
    <div class="row">
        <span>الحالة:</span>
        <span class="badge"><?= $request['Status'] ?></span>
    </div>

   <?php if($request['Status']==='مقبول'): ?>
    <div style="text-align:center">
        <a 
          href="generated_document.php?requestID=<?= $requestID ?>"
          target="_blank"
          class="print-btn">
          🖨️ تنزيل المستند
        </a>
    </div>
<?php endif; ?>

</div>

<div class="footer">
    تم التحقق من الطلب عبر QR Code
</div>

</div>
</div>

<script>
function printDiv(){
    const content = document.getElementById('print').innerHTML;
    const body = document.body.innerHTML;
    document.body.innerHTML = content;
    window.print();
    document.body.innerHTML = body;
    location.reload();
}
</script>

</body>
</html>
