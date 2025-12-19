<?php
session_start();
require 'config.php';

$errors = [];
$success_msg = '';

// تأكد أن المستخدم مسجّل دخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$NationalID = $_SESSION['user_id']; // UserID هو الرقم الوطني

// ===========================
// 1) جلب بيانات المستخدم من جدول Citizens
// ===========================
$userQuery = $pdo->prepare("SELECT FirstName, LastName, FatherName, MotherName, Hometown FROM Citizens WHERE NationalID = ?");
$userQuery->execute([$NationalID]);
$userData = $userQuery->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    die("خطأ: البيانات الرسمية للمستخدم غير موجودة!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ChildName = trim($_POST['child_name']);
    $FatherName = trim($_POST['father_name']);
    $MotherName = trim($_POST['mother_name']);
    $DateOfBirth = $_POST['birth_date'];
    $PlaceOfBirth = trim($_POST['birth_place']);
    $Governorate = $_POST['governorate'];
    $District = trim($_POST['district']);
    $DoctorName = trim($_POST['doctor_name']);

    // ===========================
    // 2) تحقق من الحقول الفارغة
    // ===========================
    if (!$ChildName || !$FatherName || !$MotherName || !$DateOfBirth || !$PlaceOfBirth || !$Governorate || !$District || !$DoctorName) {
        $errors[] = "الرجاء تعبئة جميع الحقول المطلوبة.";
    }

    // ===========================
    // 3) تحقق من تطابق البيانات مع جدول Citizens
    // ===========================
    if ($FatherName !== $userData['FatherName']) {
        $errors[] = "❌ اسم الأب لا يطابق البيانات الرسمية!";
    }
    if ($MotherName !== $userData['MotherName']) {
        $errors[] = "❌ اسم الأم لا يطابق البيانات الرسمية!";
    }
   

    // ===========================
    // 4) إضافة الطلب إذا لا توجد أخطاء
    // ===========================
    if (!$errors) {
        $sql = "INSERT INTO birth_certificate 
                (UserID, ChildName, FatherName, MotherName, DateOfBirth, PlaceOfBirth, Governorate, District, DoctorName)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $NationalID, $ChildName, $FatherName, $MotherName,
            $DateOfBirth, $PlaceOfBirth, $Governorate, $District, $DoctorName
        ]);

        $success_msg = "✅ تم إرسال طلب وثيقة الولادة بنجاح!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>طلب وثيقة ولادة</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Cairo', sans-serif; background: #f6fafb; color: #0A7075; margin:0; padding:0; }
.container { max-width: 600px; background: #fff; margin: 60px auto; padding: 40px 30px; border-radius: 20px; box-shadow: 0 8px 25px rgba(10,112,117,0.15); }
h2 { text-align:center; color:#0A7075; font-weight:800; margin-bottom:30px; }
form label { display:block; font-weight:600; margin-bottom:5px; color:#0A7075; }
form input, form select { width:100%; padding:10px; border:1px solid #ccc; border-radius:10px; margin-bottom:20px; font-family:'Cairo',sans-serif; }
.btn-primary { background-color:#0A7075; color:white; border:none; padding:12px 25px; border-radius:12px; font-weight:700; cursor:pointer; width:100%; transition:0.3s; }
.btn-primary:hover { background-color:#095d62; }
.back-link { text-align:center; display:block; margin-top:20px; color:#0A7075; text-decoration:none; }
.back-link:hover { text-decoration:underline; }
.alert-success { background-color:#d1e7dd; color:#0f5132; padding:10px; border-radius:8px; margin-bottom:15px; font-weight:600; text-align:center; }
.alert-danger { background-color:#f8d7da; color:#842029; padding:10px; border-radius:8px; margin-bottom:15px; font-weight:600; text-align:center; }
@media(max-width:480px){.container{width:90%;margin:40px auto;}}
</style>
</head>
<body>

<div class="container">
  <h2>طلب وثيقة ولادة</h2>

  <?php if ($errors): ?>
    <div class="alert-danger">
      <?php foreach ($errors as $e) echo "<div>" . htmlspecialchars($e) . "</div>"; ?>
    </div>
  <?php endif; ?>

  <?php if ($success_msg): ?>
    <div class="alert-success">
      <?php echo $success_msg; ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <label>اسم الطفل:</label>
    <input type="text" name="child_name" required>

    <label>اسم الأب:</label>
    <input type="text" name="father_name" required>

    <label>اسم الأم:</label>
    <input type="text" name="mother_name" required>

    <label>تاريخ الولادة:</label>
    <input type="date" name="birth_date" required>

    <label>مكان الولادة:</label>
    <input type="text" name="birth_place" required>

    <label>المحافظة:</label>
    <select name="governorate" required>
        <option value="">اختر المحافظة</option>
        <option value="صيدا">صيدا</option>
        <option value="بيروت">بيروت</option>
        <option value="الجنوب">الجنوب</option>
        <option value="اللبنان">جبل لبنان</option>
        <option value="الشمال">الشمال</option>
    </select>

    <label>القضاء:</label>
    <input type="text" name="district" required>

    <label>اسم الطبيب:</label>
    <input type="text" name="doctor_name" required>

    <button type="submit" class="btn-primary">إرسال الطلب</button>
  </form>

  <a href="index.php" class="back-link">العودة إلى الصفحة الرئيسية</a>
</div>

</body>
</html>
