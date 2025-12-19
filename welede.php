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

// تحديد نوع المعاملة
$type = $request['TransactionType'];
?>

<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($type) ?> – نموذج</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600&display=swap" rel="stylesheet">
<style>
/* نفس ستايل الورقة من الكود السابق */
* { box-sizing: border-box; }
body { font-family: 'Cairo', Arial, sans-serif; background: #0A7075; padding: 24px; display: flex; justify-content: center; }
.paper { background: #fff; width: 900px; max-width: 95%; padding: 20px; border: 1px solid #ddd; box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
.header { display: flex; align-items: flex-start; gap: 16px; padding-bottom: 12px; border-bottom: 1px solid #e6e6e6; }
.logo-area { width: 140px; }
.photo { width: 140px; height: 170px; object-fit: cover; border: 4px solid #f3f3f3; }
.title-area { flex: 1; text-align: center; }
.title-area h1 { margin: 6px 0; font-size: 28px; }
.title-area .sub { margin: 0; font-size: 13px; color: #555; }
.qr-area { width: 120px; display: flex; justify-content: center; align-items: center; }
.qr-placeholder { width: 90px; height: 90px; background: #eee; border: 1px dashed #ccc; display: flex; justify-content: center; align-items: center; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; }
th, td { padding: 12px; border: 1px solid #e8e8e8; }
th { background: #fafafa; width: 160px; font-weight: bold; }
.notes { margin-top: 18px; padding: 12px; border: 1px dashed #e0e0e0; background: #fbfbfb; }
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
      <img src="<?= $type=='وثيقة ولادة' ? 'baby.jpg' : 'default.jpg' ?>" alt="photo" class="photo">
    </div>
    <div class="title-area">
      <h1><?= htmlspecialchars($type) ?></h1>
      <p class="sub">الجمهورية اللبنانية – وزارة الداخلية والبلديات</p>
    </div>
    <div class="qr-area">
      <div class="qr-placeholder">QR</div>
    </div>
  </header>

  <main class="main-table">
    <table>
    <?php
    // اختيار الحقول حسب نوع المعاملة
    switch($type){
        case 'وثيقة ولادة':
            echo "
            <tr><th>اسم الطفل</th><td contenteditable='true'>{$citizen['FirstName']}</td>
                <th>شهرة الطفل</th><td contenteditable='true'>{$citizen['LastName']}</td></tr>
            <tr><th>الجنس</th><td contenteditable='true'>{$citizen['Gender']}</td>
                <th>فئة الدم</th><td contenteditable='true'>{$citizen['blood_type']}</td></tr>
            <tr><th>محل وتاريخ الولادة</th><td contenteditable='true'>{$citizen['Hometown']} - {$citizen['DateOfBirth']}</td>
                <th>رقم السجل</th><td contenteditable='true'>{$citizen['NationalID']}</td></tr>
            <tr><th>اسم الأب</th><td contenteditable='true'>{$citizen['FatherName']}</td>
                <th>شهرة الأب</th><td contenteditable='true'>{$citizen['LastName']}</td></tr>
            <tr><th>اسم الأم</th><td contenteditable='true'>{$citizen['MotherName']}</td>
                <th>شهرة الأم</th><td contenteditable='true'>{$citizen['LastName']}</td></tr>
            ";
            break;

        case 'وثيقة زواج':
            echo "
            <tr><th>اسم الزوج</th><td contenteditable='true'>{$citizen['FirstName']}</td>
                <th>شهرة الزوج</th><td contenteditable='true'>{$citizen['LastName']}</td></tr>
            <tr><th>اسم الزوجة</th><td contenteditable='true'>{$citizen['SpouseName']}</td>
                <th>شهرة الزوجة</th><td contenteditable='true'>{$citizen['SpouseLastName']}</td></tr>
            <tr><th>تاريخ الزواج</th><td contenteditable='true'>{$request['MarriageDate']}</td>
                <th>مكان الزواج</th><td contenteditable='true'>{$request['MarriagePlace']}</td></tr>
            ";
            break;

        // ممكن تضيف باقي الحالات: وثيقة وفاة، إخراج قيد عائلة، إخراج قيد فردي، هوية
        default:
            echo "<tr><td colspan='4'>لا توجد بيانات محددة لهذه المعاملة بعد.</td></tr>";
    }
    ?>
    </table>

    <section class="notes">
      <h3>ملاحظات</h3>
      <p contenteditable="true"><?= $request['Notes'] ?? "لا توجد ملاحظات" ?></p>
    </section>

    <form method="POST" action="generate_pdf.php">
        <input type="hidden" name="requestID" value="<?= $requestID ?>">
        <button type="submit">إنشاء / تحميل الوثيقة</button>
    </form>
  </main>

  <footer class="footer">
    <div class="stamp">ختم المختار</div>
    <div class="sign">التوقيع: ____________</div>
  </footer>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("td, .notes p").forEach(td => {
    td.addEventListener("dblclick", () => {
      if(td.isContentEditable){
        td.contentEditable = "false";
      }else{
        td.contentEditable = "true";
        td.focus();
      }
    });
  });
});
</script>
</body>
</html>
