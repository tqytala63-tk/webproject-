<?php
session_start();
require 'config.php';

// ✅ تأكد أن المستخدم مسجّل دخول
if (!isset($_SESSION['user_id'])) {
    $current_page = basename($_SERVER['PHP_SELF']);
    header("Location: login.php?redirect=$current_page");
    exit;
}

$UserID = $_SESSION['user_id'];
$success = false;
$error = "";

// حفظ البيانات عند الإرسال
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HusbandName = !empty($_POST['husband_name']) ? trim($_POST['husband_name']) : null;
    $WifeName = !empty($_POST['wife_name']) ? trim($_POST['wife_name']) : null;
    $MarriageDate = !empty($_POST['marriage_date']) ? $_POST['marriage_date'] : null;
    $PlaceOfMarriage = !empty($_POST['marriage_place']) ? trim($_POST['marriage_place']) : null;
    $Governorate = !empty($_POST['governorate']) ? trim($_POST['governorate']) : null;
    $District = !empty($_POST['district']) ? trim($_POST['district']) : null;
    $Witness1 = !empty($_POST['witness1']) ? trim($_POST['witness1']) : null;
    $Witness2 = !empty($_POST['witness2']) ? trim($_POST['witness2']) : null;
    $ImamOrJudge = !empty($_POST['imam_or_judge']) ? trim($_POST['imam_or_judge']) : null;

    try {
        $sql = "INSERT INTO marriage_certificate 
                (UserID, HusbandName, WifeName, MarriageDate, PlaceOfMarriage, Governorate, District, Witness1, Witness2, ImamOrJudge)
                VALUES (:UserID, :HusbandName, :WifeName, :MarriageDate, :PlaceOfMarriage, :Governorate, :District, :Witness1, :Witness2, :ImamOrJudge)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':UserID' => $UserID,
            ':HusbandName' => $HusbandName,
            ':WifeName' => $WifeName,
            ':MarriageDate' => $MarriageDate,
            ':PlaceOfMarriage' => $PlaceOfMarriage,
            ':Governorate' => $Governorate,
            ':District' => $District,
            ':Witness1' => $Witness1,
            ':Witness2' => $Witness2,
            ':ImamOrJudge' => $ImamOrJudge
        ]);

        $success = true;
    } catch (PDOException $e) {
        $error = "❌ حدث خطأ: " . $e->getMessage();
    }
}

// جلب آخر طلب للمستخدم (عرض البيانات)
$stmt2 = $pdo->prepare("SELECT * FROM marriage_certificate WHERE UserID = :uid ORDER BY MarriageID DESC LIMIT 1");
$stmt2->execute([':uid' => $UserID]);
$lastMarriage = $stmt2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>طلب وثيقة زواج</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body {font-family: 'Cairo', sans-serif; background:#f6fafb; color:#0A7075; margin:0; padding:0;}
.container {max-width:600px; background:#fff; margin:60px auto; padding:40px 30px; border-radius:20px; box-shadow:0 8px 25px rgba(10,112,117,0.15);}
h2 {text-align:center; color:#0A7075; font-weight:800; margin-bottom:30px;}
form label {display:block; font-weight:600; margin-bottom:5px; color:#0A7075;}
form input, form select {width:100%; padding:10px; border:1px solid #ccc; border-radius:10px; margin-bottom:20px; font-family:'Cairo', sans-serif;}
.btn-primary {background-color:#0A7075; color:white; border:none; padding:12px 25px; border-radius:12px; font-weight:700; cursor:pointer; width:100%; transition:0.3s;}
.btn-primary:hover {background-color:#095d62;}
.back-link {text-align:center; display:block; margin-top:20px; color:#0A7075; text-decoration:none;}
.back-link:hover {text-decoration:underline;}
.success-msg {background:#d4edda; color:#155724; padding:10px 15px; border-radius:10px; margin-bottom:20px;}
.error-msg {background:#f8d7da; color:#721c24; padding:10px 15px; border-radius:10px; margin-bottom:20px;}
.last-record {background:#e9f7f7; padding:15px; border-radius:10px; margin-top:30px;}
</style>
</head>
<body>

<div class="container">
<h2>طلب وثيقة زواج</h2>

<?php if($success) echo "<div class='success-msg'>✅ تم إرسال طلب وثيقة الزواج بنجاح!</div>"; ?>
<?php if($error) echo "<div class='error-msg'>$error</div>"; ?>

<form method="POST">
  <label>اسم الزوج:</label>
  <input type="text" name="husband_name" required>

  <label>اسم الزوجة:</label>
  <input type="text" name="wife_name" required>

  <label>تاريخ الزواج:</label>
  <input type="date" name="marriage_date" required>

  <label>مكان الزواج:</label>
  <input type="text" name="marriage_place" required>

  <label>المحافظة:</label>
  <select name="governorate" required>
    <option value="">اختر المحافظة</option>
    <option value="صيدا">صيدا</option>
    <option value="بيروت">بيروت</option>
    <option value="الجنوب">الجنوب</option>
    <option value="جبل لبنان">جبل لبنان</option>
    <option value="الشمال">الشمال</option>
  </select>

  <label>القضاء:</label>
  <input type="text" name="district" required>

  <label>اسم الشاهد الأول:</label>
  <input type="text" name="witness1" required>

  <label>اسم الشاهد الثاني:</label>
  <input type="text" name="witness2" required>

  <label>اسم الشيخ أو القاضي:</label>
  <input type="text" name="imam_or_judge" required>

  <button type="submit" class="btn-primary">إرسال الطلب</button>
</form>



<a href="index.php" class="back-link">العودة إلى الصفحة الرئيسية</a>
</div>

</body>
</html>
