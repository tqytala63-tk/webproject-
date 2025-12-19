<?php
require 'config.php';

// تأكد أن المستخدم مسجّل دخول
if (!isset($_SESSION['user_id'])) {
    $current_page = basename($_SERVER['PHP_SELF']);
    header("Location: login.php?redirect=$current_page");
    exit;
}

$success_msg = ""; // رسالة النجاح

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserID = $_SESSION['user_id'];
    $DeceasedName = $_POST['deceased_name'];
    $FatherName = $_POST['father_name'];
    $MotherName = $_POST['mother_name'];
    $DateOfDeath = $_POST['death_date'];
    $PlaceOfDeath = $_POST['death_place'];
    $Governorate = $_POST['governorate'];
    $District = $_POST['district'];
    $CauseOfDeath = $_POST['cause_of_death'];
    $DoctorName = $_POST['doctor_name'];

    // حفظ البيانات في قاعدة البيانات
    $sql = "INSERT INTO death_certificate 
        (UserID, DeceasedName, FatherName, MotherName, DateOfDeath, PlaceOfDeath, Governorate, District, CauseOfDeath, DoctorName)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$UserID, $DeceasedName, $FatherName, $MotherName, $DateOfDeath, $PlaceOfDeath, $Governorate, $District, $CauseOfDeath, $DoctorName]);

    $success_msg = "✅ تم إرسال طلب وثيقة الوفاة بنجاح!";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>طلب وثيقة وفاة</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Cairo', sans-serif; background: #f6fafb; color: #0A7075; margin:0; padding:0; }
.container { max-width: 600px; background: #fff; margin: 60px auto; padding: 40px 30px; border-radius: 20px; box-shadow:0 8px 25px rgba(10,112,117,0.15);}
h2 { text-align:center; color:#0A7075; font-weight:800; margin-bottom:30px; }
form label { display:block; font-weight:600; margin-bottom:5px; color:#0A7075; }
form input, form select, form textarea { width:100%; padding:10px; border:1px solid #ccc; border-radius:10px; margin-bottom:20px; font-family:'Cairo',sans-serif;}
textarea { resize:none; height:80px; }
.btn-primary { background-color:#0A7075; color:white; border:none; padding:12px 25px; border-radius:12px; font-weight:700; cursor:pointer; width:100%; transition:0.3s; }
.btn-primary:hover { background-color:#095d62; }
.back-link { text-align:center; display:block; margin-top:20px; color:#0A7075; text-decoration:none; }
.back-link:hover { text-decoration:underline; }
.success-msg { background:#d4edda; color:#155724; padding:10px 15px; border-radius:10px; margin-bottom:20px; text-align:center; font-weight:700; }
</style>
</head>
<body>
<div class="container">
<h2>طلب وثيقة وفاة</h2>

<?php if($success_msg): ?>
<div class="success-msg"><?= $success_msg ?></div>
<?php endif; ?>

<form method="POST">

<label>اسم المتوفى:</label>
<input type="text" name="deceased_name" required>

<label>اسم الأب:</label>
<input type="text" name="father_name" required>

<label>اسم الأم:</label>
<input type="text" name="mother_name" required>

<label>تاريخ الوفاة:</label>
<input type="date" name="death_date" required>

<label>مكان الوفاة:</label>
<input type="text" name="death_place" required>

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

<label>سبب الوفاة:</label>
<textarea name="cause_of_death" required></textarea>

<label>اسم الطبيب:</label>
<input type="text" name="doctor_name" required>

<button type="submit" class="btn-primary">إرسال الطلب</button>
</form>

<a href="index.php" class="back-link">العودة إلى الصفحة الرئيسية</a>
</div>
</body>
</html>
