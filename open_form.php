<?php
session_start();
require 'config.php';

if(!isset($_GET['requestID'])) die("⚠ RequestID مفقود");
$requestID = $_GET['requestID'];


// جلب بيانات الطلب
$stmt = $pdo->prepare("SELECT * FROM Requests WHERE RequestID = ?");
$stmt->execute([$requestID]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$request) die("⚠ الطلب غير موجود");

// جلب بيانات المواطن
$stmt2 = $pdo->prepare("SELECT * FROM citizens WHERE NationalID = ?");
$stmt2->execute([$request['UserID']]);
$citizen = $stmt2->fetch(PDO::FETCH_ASSOC);
if(!$citizen) die("⚠ المواطن غير موجود");

$docType = trim($request['TransactionType']); // إزالة المسافات الزائدة
$status = $request['Status'];

// تحقق من حالة الطلب
if($status !== 'مقبول') {
    die("<p>⚠ الطلب ما زال غير مقبول أو مرفوض، لا يمكن عرض النموذج.</p>");
}

// دالة لإظهار الحقول حسب نوع الوثيقة
function renderFields($docType, $citizen, $request) {
    switch($docType) {
        case 'وثيقة ولادة':
            ?>
            <tr><th>اسم الطفل</th><td contenteditable="true"><?= htmlspecialchars($citizen['FirstName']) ?></td>
                <th>شهرة الطفل</th><td contenteditable="true"><?= htmlspecialchars($citizen['LastName']) ?></td></tr>

            <tr><th>الجنس</th><td contenteditable="true"><?= htmlspecialchars($citizen['Gender']) ?></td>
                <th>فئة الدم</th><td contenteditable="true"><?= htmlspecialchars($citizen['blood_type']) ?></td></tr>

            <tr><th>محل وتاريخ الولادة</th><td contenteditable="true"><?= htmlspecialchars($citizen['Hometown'] . " - " . $citizen['DateOfBirth']) ?></td>
                <th>رقم الوطني</th><td contenteditable="true"><?= htmlspecialchars($citizen['NationalID']) ?></td></tr>

            <tr><th>اسم الأب</th><td contenteditable="true"><?= htmlspecialchars($citizen['FatherName']) ?></td>
                <th>شهرة الأب</th><td contenteditable="true"><?= htmlspecialchars($citizen['LastName']) ?></td></tr>

            <tr><th>اسم الأم</th><td contenteditable="true"><?= htmlspecialchars($citizen['MotherName']) ?></td>
                <th>شهرة الأم</th><td contenteditable="true"><?= htmlspecialchars($citizen['LastName']) ?></td></tr>

            <tr><th>القرية</th><td contenteditable="true"><?= htmlspecialchars($citizen['Hometown']) ?></td>
                <th>القضاء</th><td contenteditable="true"><?= htmlspecialchars($citizen['District']) ?></td></tr>

            <tr><th>المحافظة</th><td contenteditable="true"><?= htmlspecialchars($citizen['Governorate']) ?></td></tr>
            <?php
            break;

            case 'إخراج قيد عائلي':
?>
<tr><th>اسم رب العائلة</th><td contenteditable="true"><?= htmlspecialchars($citizen['FatherName']) ?></td>
    <th>شهرة العائلة</th><td contenteditable="true"><?= htmlspecialchars($citizen['LastName']) ?></td></tr>

<tr><th>اسم الزوجة</th><td contenteditable="true"><?= htmlspecialchars($citizen['MotherName']) ?></td>
    <th>عدد الأولاد</th><td contenteditable="true"><?= htmlspecialchars($citizen['ChildrenCount'] ?? '') ?></td></tr>

<tr><th>رقم الوطني</th><td contenteditable="true"><?= htmlspecialchars($citizen['NationalID']) ?></td>
    <th>القضاء</th><td contenteditable="true"><?= htmlspecialchars($citizen['District']) ?></td></tr>

<tr><th>القرية</th><td contenteditable="true"><?= htmlspecialchars($citizen['Hometown']) ?></td>
    <th>المحافظة</th><td contenteditable="true"><?= htmlspecialchars($citizen['Governorate']) ?></td></tr>

<?php
break;

case 'بطاقة الهوية':
?>
<tr><th>الاسم الكامل</th><td contenteditable="true"><?= htmlspecialchars($citizen['FirstName'] . " " . $citizen['LastName']) ?></td>
    <th>الجنس</th><td contenteditable="true"><?= htmlspecialchars($citizen['Gender']) ?></td></tr>

<tr><th>اسم الأب</th><td contenteditable="true"><?= htmlspecialchars($citizen['FatherName']) ?></td>
    <th>اسم الأم</th><td contenteditable="true"><?= htmlspecialchars($citizen['MotherName']) ?></td></tr>

<tr><th>تاريخ الولادة</th><td contenteditable="true"><?= htmlspecialchars($citizen['DateOfBirth']) ?></td>
    <th>محل الولادة</th><td contenteditable="true"><?= htmlspecialchars($citizen['Hometown']) ?></td></tr>

<tr><th>رقم الوطني</th><td contenteditable="true"><?= htmlspecialchars($citizen['NationalID']) ?></td>
    <th>القضاء</th><td contenteditable="true"><?= htmlspecialchars($citizen['District']) ?></td></tr>

<tr><th>المحافظة</th><td contenteditable="true"><?= htmlspecialchars($citizen['Governorate']) ?></td>
    <th>فئة الدم</th><td contenteditable="true"><?= htmlspecialchars($citizen['blood_type']) ?></td></tr>

<?php
break;


        case 'وثيقة وفاة':
?>
<tr><th>اسم المتوفي</th><td contenteditable="true"><?= htmlspecialchars($citizen['FirstName']) ?></td>
    <th>شهرة المتوفي</th><td contenteditable="true"><?= htmlspecialchars($citizen['LastName']) ?></td></tr>

<tr><th>الجنس</th><td contenteditable="true"><?= htmlspecialchars($citizen['Gender']) ?></td>
    <th>تاريخ الوفاة</th><td contenteditable="true"><?= htmlspecialchars($citizen['DeathDate'] ?? '') ?></td></tr>

<tr><th>محل الوفاة</th><td contenteditable="true"><?= htmlspecialchars($citizen['DeathPlace'] ?? '') ?></td>
    <th>رقم الوطني</th><td contenteditable="true"><?= htmlspecialchars($citizen['NationalID']) ?></td></tr>

<tr><th>اسم الأب</th><td contenteditable="true"><?= htmlspecialchars($citizen['FatherName']) ?></td>
    <th>اسم الأم</th><td contenteditable="true"><?= htmlspecialchars($citizen['MotherName']) ?></td></tr>

<tr><th>القرية</th><td contenteditable="true"><?= htmlspecialchars($citizen['Hometown']) ?></td>
    <th>القضاء</th><td contenteditable="true"><?= htmlspecialchars($citizen['District']) ?></td></tr>

<tr><th>المنطقة</th><td contenteditable="true"><?= htmlspecialchars($citizen['Governorate']) ?></td></tr>
<?php
break;

       

       case 'وثيقة زواج':
?>
<tr><th>اسم الزوج</th><td contenteditable="true"><?= htmlspecialchars($citizen['FirstName']) ?></td>
    <th>شهرة الزوج</th><td contenteditable="true"><?= htmlspecialchars($citizen['LastName']) ?></td></tr>
<tr><th>اسم الزوجة</th><td contenteditable="true"><?= htmlspecialchars($citizen['SpouseName'] ?? '') ?></td>
    <th>شهرة الزوجة</th><td contenteditable="true"><?= htmlspecialchars($citizen['SpouseLastName'] ?? '') ?></td></tr>
<tr><th>تاريخ الزواج</th><td contenteditable="true"><?= htmlspecialchars($citizen['MarriageDate'] ?? '') ?></td></tr>
<tr><th>مكان الزواج</th><td contenteditable="true"><?= htmlspecialchars($citizen['MarriagePlace'] ?? '') ?></td></tr>
<?php
break;


        case 'إخراج قيد فردي':
?>
<tr><th>الاسم الكامل</th><td contenteditable="true"><?= htmlspecialchars($citizen['FirstName'] . " " . $citizen['LastName']) ?></td></tr>
<tr><th>اسم الأب</th><td contenteditable="true"><?= htmlspecialchars($citizen['FatherName']) ?></td></tr>
<tr><th>اسم الأم</th><td contenteditable="true"><?= htmlspecialchars($citizen['MotherName']) ?></td></tr>
<tr><th>رقم الوطني</th><td contenteditable="true"><?= htmlspecialchars($citizen['NationalID']) ?></td></tr>
<tr><th>القرية</th><td contenteditable="true"><?= htmlspecialchars($citizen['Hometown']) ?></td></tr>
<tr><th>القضاء</th><td contenteditable="true"><?= htmlspecialchars($citizen['District']) ?></td></tr>
<tr><th>المنطقة</th><td contenteditable="true"><?= htmlspecialchars($citizen['Governorate']) ?></td></tr>

<?php
break;


        default:
            echo "<tr><td colspan='4'>⚠ نوع الوثيقة غير معروف: " . htmlspecialchars($docType) . "</td></tr>";
    }
}
?>

<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($docType) ?> – نموذج</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Cairo', Arial, sans-serif; background: #0A7075; padding: 24px; display: flex; justify-content: center; }
.paper { background: #fff; width: 900px; max-width: 95%; padding: 20px; border: 1px solid #ddd; box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
.header { display: flex; align-items: flex-start; gap: 16px; padding-bottom: 12px; border-bottom: 1px solid #e6e6e6; }
.logo-area { width: 140px; }
.photo { width: 140px; height: 170px; object-fit: cover; border: 4px solid #f3f3f3; }
.title-area { flex: 1; text-align: center; }
.title-area h1 { margin: 6px 0; font-size: 28px; }
.title-area .sub { margin: 0; font-size: 13px; color: #555; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; }
th, td { padding: 12px; border: 1px solid #e8e8e8; }
th { background: #fafafa; width: 160px; font-weight: bold; }
.footer { display: flex; justify-content: space-between; margin-top: 20px; }
.stamp { padding: 10px 18px; border: 2px solid #e0e0e0; background: #f9f9f9; font-weight: bold; }
.sign { font-size: 14px; }
button { margin-top: 15px; padding: 10px 16px; border:none; background:#0A7075; color:white; border-radius:6px; cursor:pointer; font-weight:600; }
td[contenteditable="true"] { background: #fffbe6; }
</style>
</head>
<body>
<div class="paper">
  <header class="header">
    <div class="logo-area">
      <img src="logo.jpg" alt="photo" class="photo">
    </div>
    <div class="title-area">
      <h1><?= htmlspecialchars($docType) ?></h1>
       <p>الجمهورية اللبنانية – دائرة النفوس  </p>

      <p class="sub">تاريخ تقديم الطلب: <?= htmlspecialchars($request['RequestDate']) ?></p>

    </div>
  </header>

  <main class="main-table">
    <table>
      <?php renderFields($docType, $citizen, $request); ?>
    </table>

    <?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'): ?>
<form method="POST" action="accept_request.php">
    <input type="hidden" name="requestID" value="<?= $requestID ?>">
    <button type="submit">إنشاء</button>
</form>
<?php endif; ?>



<script>
document.getElementById('acceptForm').addEventListener('submit', function(e){
    e.preventDefault(); // منع إعادة التحميل
    let formData = new FormData(this);
    fetch('accept_request.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert(data); // يظهر رسالة "تم قبول الطلب"
        // ممكن تغيّر زر أو الحالة على الصفحة مباشرة
    })
    .catch(err => console.error(err));
});
</script>


  <footer class="footer">
    <div class="stamp">ختم المختار</div>
    <div class="sign">التوقيع: ____________</div>
  </footer>
</div>
</body>
</html>
