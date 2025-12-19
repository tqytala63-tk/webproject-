<?php
session_start();
require 'config.php';

$errors = [];
$success_msg = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// الرقم الوطني للمستخدم
$nationalID = $_SESSION['user_id'];

// جلب البيانات الرسمية للمواطن من جدول Citizens
$stmt = $pdo->prepare("SELECT FirstName, LastName, FatherName, MotherName, DateOfBirth FROM Citizens WHERE NationalID = ?");
$stmt->execute([$nationalID]);
$citizen = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$citizen) {
    die("خطأ: البيانات الرسمية للمستخدم غير موجودة!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Governorate = $_POST['governorate'];
    $District = trim($_POST['district']);
    $Town = trim($_POST['town'] ?? '');
    $Address = trim($_POST['address'] ?? '');

    if (!$Governorate || !$District) {
        $errors[] = "الرجاء تعبئة جميع الحقول المطلوبة.";
    } else {
        $sql = "INSERT INTO id_card (UserID, FullName, FatherName, MotherName, BirthDate, Governorate, District, Town, Address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nationalID,
            $citizen['FirstName'] . ' ' . $citizen['LastName'],
            $citizen['FatherName'],
            $citizen['MotherName'],
            $citizen['DateOfBirth'],
            $Governorate,
            $District,
            $Town,
            $Address
        ]);

        $success_msg = "✅ تم إرسال طلب بطاقة الهوية بنجاح!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>طلب بطاقة الهوية</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
/* نفس التنسيقات من الكود السابق */
</style>
</head>
<body>

<div class="container">
  <h2>طلب بطاقة الهوية</h2>

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
    <label>الاسم الكامل:</label>
    <input type="text" value="<?php echo htmlspecialchars($citizen['FirstName'].' '.$citizen['LastName']); ?>" readonly>

    <label>اسم الأب:</label>
    <input type="text" value="<?php echo htmlspecialchars($citizen['FatherName']); ?>" readonly>

    <label>اسم الأم:</label>
    <input type="text" value="<?php echo htmlspecialchars($citizen['MotherName']); ?>" readonly>

    <label>تاريخ الميلاد:</label>
    <input type="date" value="<?php echo htmlspecialchars($citizen['DateOfBirth']); ?>" readonly>

    <label>المحافظة:</label>
    <select name="governorate" required>
        <option value="">اختر المحافظة</option>
        <option value="صيدا">صيدا</option>
        <option value="بيروت">بيروت</option>
        <option value="الجنوب">الجنوب</option>
        <option value="اللبنان">جبل لبنان</option>
        <option value="الشمال">الشمال</option>
    </select>

    <label>اسم المنطقة/القضاء:</label>
    <input type="text" name="district" required>

    <label>اسم البلدة (اختياري):</label>
    <input type="text" name="town">

    <label>العنوان (اختياري):</label>
    <input type="text" name="address">

    <button type="submit" class="btn-primary">إرسال الطلب</button>
  </form>

  <a href="index.php" class="back-link">العودة إلى الصفحة الرئيسية</a>
</div>

</body>
</html>

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

</html>
