<?php
session_start();
require 'config.php';

$errors = [];
$success_msg = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// استخدم UserID بدل NationalID
$userID = $_SESSION['user_id'];
$nationalID = $userID; // إذا UserID هو الرقم الوطني

// جلب البيانات الرسمية للمواطن من جدول Citizens
$stmt = $pdo->prepare("SELECT FirstName, LastName, FatherName, MotherName FROM Citizens WHERE NationalID = ?");
$stmt->execute([$nationalID]);
$citizen = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$citizen) {
    die("خطأ: البيانات الرسمية للمستخدم غير موجودة!");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FamilyName = trim($_POST['family_name']);
    $FatherName = trim($_POST['father_name']);
    $MotherName = trim($_POST['mother_name']);
    $Governorate = $_POST['governorate'];
    $District = trim($_POST['district']);
    $Town = trim($_POST['town']);
    $Address = trim($_POST['address']);
    $NumberOfMembers = intval($_POST['num_members']);

    // التحقق من تطابق البيانات مع جدول Citizens
    if ($FamilyName != $citizen['LastName']) {
        $errors[] = "اسم العائلة لا يطابق البيانات الرسمية!";
    }
    if ($FatherName != $citizen['FatherName']) {
        $errors[] = "اسم الأب لا يطابق البيانات الرسمية!";
    }
    if ($MotherName != $citizen['MotherName']) {
        $errors[] = "اسم الأم لا يطابق البيانات الرسمية!";
    }

    // التحقق من الحقول المطلوبة
    if (!$Governorate || !$District || !$Town || !$Address || !$NumberOfMembers) {
        $errors[] = "الرجاء تعبئة جميع الحقول المطلوبة.";
    }

    // إذا ما في أخطاء، حفظ الطلب
    if (empty($errors)) {
        $sql = "INSERT INTO family_extract 
                (UserID, FamilyName, FatherName, MotherName, Governorate, District, Town, Address, NumberOfMembers) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $userID,
            $FamilyName,
            $FatherName,
            $MotherName,
            $Governorate,
            $District,
            $Town,
            $Address,
            $NumberOfMembers
        ]);

        $success_msg = "✅ تم إرسال طلب إخراج قيد العائلة بنجاح!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>طلب إخراج قيد عائلي</title>
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
  <h2>طلب إخراج قيد عائلي</h2>

  <?php if ($errors): ?>
    <div class="alert-danger">
      <?php foreach ($errors as $e) echo "<div>" . htmlspecialchars($e) . "</div>"; ?>
    </div>
  <?php endif; ?>

  <?php if ($success_msg): ?>
    <div class="alert-success"><?php echo $success_msg; ?></div>
  <?php endif; ?>

  <form method="POST">
    <label>اسم العائلة:</label>
    <input type="text" name="family_name" required>

    <label>اسم الأب:</label>
    <input type="text" name="father_name" required>

    <label>اسم الأم:</label>
    <input type="text" name="mother_name" required>

    <label>المحافظة:</label>
    <select name="governorate" required>
        <option value="">اختر المحافظة</option>
        <option value="بيروت">بيروت</option>
        <option value="جبل لبنان">جبل لبنان</option>
        <option value="الشمال">الشمال</option>
        <option value="الجنوب">الجنوب</option>
        <option value="البقاع">البقاع</option>
        <option value="بعلبك الهرمل">بعلبك الهرمل</option>
    </select>

    <label>القضاء:</label>
    <input type="text" name="district" required>

    <label>البلدة:</label>
    <input type="text" name="town" required>

    <label>العنوان:</label>
    <input type="text" name="address" required>

    <label>عدد أفراد العائلة:</label>
    <input type="number" name="num_members" min="1" required>

    <button type="submit" class="btn-primary">إرسال الطلب</button>
  </form>

  <a href="index.php" class="back-link">العودة إلى الصفحة الرئيسية</a>
</div>

</body>
</html>
