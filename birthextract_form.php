<?php
session_start();
require 'config.php';

// تأكد أن المستخدم مسجّل دخول
if (!isset($_SESSION['user_id'])) {
    $current_page = basename($_SERVER['PHP_SELF']);
    header("Location: login.php?redirect=$current_page");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // القيم من النموذج (استخدم قيمة فارغة أو null إذا ما تم إدخالها)
    $UserID = $_SESSION['user_id'];

    $Governorate = !empty($_POST['governorate']) ? trim($_POST['governorate']) : null;
    $District = !empty($_POST['district']) ? trim($_POST['district']) : null;
    $Town = !empty($_POST['town']) ? trim($_POST['town']) : null;

    $FirstName = !empty($_POST['first_name']) ? trim($_POST['first_name']) : null;
    $FatherName = !empty($_POST['father_name']) ? trim($_POST['father_name']) : null;
    $FamilyName = !empty($_POST['family_name']) ? trim($_POST['family_name']) : null;
    
    $MotherFamilyName = !empty($_POST['mother_family_name']) ? trim($_POST['mother_family_name']) : null;

    // تاريخ الولادة: نسمح للمستخدم يدخل input[type=date] ثم نقسمها
    $BirthYear = null; $BirthMonth = null; $BirthDay = null;
    if (!empty($_POST['birth_date'])) {
        $d = $_POST['birth_date']; // format: YYYY-MM-DD
        $parts = explode('-', $d);
        if (count($parts) === 3) {
            $BirthYear = (int)$parts[0];
            $BirthMonth = (int)$parts[1];
            $BirthDay = (int)$parts[2];
        }
    } else {
        // بدنا نسمح للمستخدم يدخل قيم منفصلة (اختياري)
        if (!empty($_POST['birth_year'])) $BirthYear = (int)$_POST['birth_year'];
        if (!empty($_POST['birth_month'])) $BirthMonth = (int)$_POST['birth_month'];
        if (!empty($_POST['birth_day'])) $BirthDay = (int)$_POST['birth_day'];
    }

    $BirthPlace = !empty($_POST['birth_place']) ? trim($_POST['birth_place']) : null;
    $Gender = !empty($_POST['gender']) ? trim($_POST['gender']) : null;
    $Religion = !empty($_POST['religion']) ? trim($_POST['religion']) : null;
    $NationalID = !empty($_POST['national_id']) ? trim($_POST['national_id']) : null;
    $RegistryNumber = !empty($_POST['registry_number']) ? trim($_POST['registry_number']) : null;

    $MaritalStatus = !empty($_POST['marital_status']) ? trim($_POST['marital_status']) : null;
    $SpouseName = !empty($_POST['spouse_name']) ? trim($_POST['spouse_name']) : null;
    $ChildrenCount = !empty($_POST['children_count']) ? (int)$_POST['children_count'] : null;

    $AddressGovernorate = !empty($_POST['address_governorate']) ? trim($_POST['address_governorate']) : null;
    $AddressDistrict = !empty($_POST['address_district']) ? trim($_POST['address_district']) : null;
    $AddressTown = !empty($_POST['address_town']) ? trim($_POST['address_town']) : null;
    $Area = !empty($_POST['area']) ? trim($_POST['area']) : null;
    $Street = !empty($_POST['street']) ? trim($_POST['street']) : null;
    $Building = !empty($_POST['building']) ? trim($_POST['building']) : null;
    $Phone = !empty($_POST['phone']) ? trim($_POST['phone']) : null;

    // مجلد رفع الصور
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $DocumentImage = null;
    if (!empty($_FILES["document_image"]["name"]) && is_uploaded_file($_FILES["document_image"]["tmp_name"])) {
        // امنع أسماء الملفات المضرة
        $safe_name = preg_replace("/[^A-Za-z0-9\-\_\.]/", '_', basename($_FILES["document_image"]["name"]));
        $target_file = $target_dir . time() . "_" . $safe_name;
        if (move_uploaded_file($_FILES["document_image"]["tmp_name"], $target_file)) {
            $DocumentImage = $target_file;
        }
    }

    // استعلام إدخال: نحدّد الحقول صراحة
    $sql = "INSERT INTO birth_extract
        (UserID, Governorate, District, Town, FirstName, FatherName, FamilyName,  MotherFamilyName,
         BirthPlace, BirthYear, BirthMonth, BirthDay, Gender, Religion, NationalID, RegistryNumber,
         MaritalStatus, SpouseName, ChildrenCount, AddressGovernorate, AddressDistrict, AddressTown, Area, Street, Building, Phone, DocumentImage)
        VALUES
        (:UserID, :Governorate, :District, :Town, :FirstName, :FatherName, :FamilyName,  :MotherFamilyName,
         :BirthPlace, :BirthYear, :BirthMonth, :BirthDay, :Gender, :Religion, :NationalID, :RegistryNumber,
         :MaritalStatus, :SpouseName, :ChildrenCount, :AddressGovernorate, :AddressDistrict, :AddressTown, :Area, :Street, :Building, :Phone, :DocumentImage)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':UserID' => $UserID,
        ':Governorate' => $Governorate,
        ':District' => $District,
        ':Town' => $Town,
        ':FirstName' => $FirstName,
        ':FatherName' => $FatherName,
        ':FamilyName' => $FamilyName,
        
        ':MotherFamilyName' => $MotherFamilyName,
        ':BirthPlace' => $BirthPlace,
        ':BirthYear' => $BirthYear,
        ':BirthMonth' => $BirthMonth,
        ':BirthDay' => $BirthDay,
        ':Gender' => $Gender,
        ':Religion' => $Religion,
        ':NationalID' => $NationalID,
        ':RegistryNumber' => $RegistryNumber,
        ':MaritalStatus' => $MaritalStatus,
        ':SpouseName' => $SpouseName,
        ':ChildrenCount' => $ChildrenCount,
        ':AddressGovernorate' => $AddressGovernorate,
        ':AddressDistrict' => $AddressDistrict,
        ':AddressTown' => $AddressTown,
        ':Area' => $Area,
        ':Street' => $Street,
        ':Building' => $Building,
        ':Phone' => $Phone,
        ':DocumentImage' => $DocumentImage
    ]);

    echo "<script>alert('✅ تم إرسال الطلب بنجاح!'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>طلب إخراج قيد فردي</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: #f6fafb;
      color: #0A7075;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      background: #fff;
      margin: 60px auto;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(10,112,117,0.15);
    }
    h2 {
      text-align: center;
      color: #0A7075;
      font-weight: 800;
      margin-bottom: 30px;
    }
    form label {
      display: block;
      font-weight: 600;
      margin-bottom: 5px;
      color: #0A7075;
    }
    form input, form select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-bottom: 20px;
      font-family: 'Cairo', sans-serif;
    }
    input[type="file"] {
      border: none;
    }
    .btn-primary {
      background-color: #0A7075;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 12px;
      font-weight: 700;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
    }
    .btn-primary:hover {
      background-color: #095d62;
    }
    .back-link {
      text-align: center;
      display: block;
      margin-top: 20px;
      color: #0A7075;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }
    /* small helper to place two inputs side-by-side on wider screens */
    .row { display: flex; gap: 10px; }
    .row .col { flex: 1; }
    @media (max-width: 520px) {
      .row { flex-direction: column; }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>طلب إخراج قيد فردي</h2>
    <form method="POST" enctype="multipart/form-data">

      <label>الاسم الأول:</label>
      <input type="text" name="first_name" >

      <div class="row">
        <div class="col">
          <label>اسم الأب:</label>
          <input type="text" name="father_name" required>
        </div>
        <div class="col">
          <label>اسم العائلة:</label>
          <input type="text" name="family_name">
        </div>
      </div>

      <div class="row">
      
        <div class="col">
          <label>اسم عائلة الأم:</label>
          <input type="text" name="mother_family_name">
        </div>
      </div>

      <label>تاريخ الولادة:</label>
      <input type="date" name="birth_date" >

      <div class="row">
        <div class="col">
          <label>مكان الولادة:</label>
          <input type="text" name="birth_place">
        </div>
        <div class="col">
          <label>الديانة:</label>
          <select name="religion" >
            <option value="">-- اختر --</option>
            <option value="مسلم">مسلم</option>
            <option value="مسيحي">مسيحي</option>
            <option value="درزي">درزي</option>
            <option value="أخرى">أخرى</option>
          </select>
        </div>
      </div>

      <label>الجنس:</label>
      <select name="gender" required>
        <option value="">-- اختر --</option>
        <option value="ذكر">ذكر</option>
        <option value="أنثى">أنثى</option>
      </select>

      <div class="row">
        <div class="col">
          <label>الرقم القومي / الهوية:</label>
          <input type="text" name="national_id">
        </div>
        <div class="col">
          <label>رقم القيد (Registry Number):</label>
          <input type="text" name="registry_number">
        </div>
      </div>

      <label>الحالة الاجتماعية:</label>
      <select name="marital_status">
        <option value="">-- اختر --</option>
        <option value="أعزب/عزباء">أعزب/عزباء</option>
        <option value="متزوج/متزوجة">متزوج/متزوجة</option>
        <option value="مطلق/مطلقة">مطلق/مطلقة</option>
        <option value="أرمل/أرملة">أرمل/أرملة</option>
      </select>

      <label>اسم الزوج/الزوجة (إن وجد):</label>
      <input type="text" name="spouse_name">

      <label>عدد الأولاد:</label>
      <input type="number" name="children_count" min="0">

      <h3 style="color:#095d62; margin-top:10px;">عنوان السكن</h3>

      <div class="row">
        <div class="col">
          <label>المحافظة (عنوان):</label>
          <input type="text" name="address_governorate">
        </div>
        <div class="col">
          <label>القضاء (عنوان):</label>
          <input type="text" name="address_district">
        </div>
      </div>

      <label>البلدة / الحي (عنوان):</label>
      <input type="text" name="address_town">

      <div class="row">
        <div class="col">
          <label>المنطقة / الحي الصغير (Area):</label>
          <input type="text" name="area">
        </div>
        <div class="col">
          <label>الشارع:</label>
          <input type="text" name="street">
        </div>
      </div>

      <label>المبنى / رقم العمارة:</label>
      <input type="text" name="building">

      <label>الهاتف:</label>
      <input type="text" name="phone">

      <label>المحافظة (مكان السجل):</label>
      <input type="text" name="governorate">

      <label>القضاء (مكان السجل):</label>
      <input type="text" name="district">

      <label>البلدة (مكان السجل):</label>
      <input type="text" name="town">

      <label>صورة المستند:</label>
      <input type="file" name="document_image" accept="image/*">

      <button type="submit" class="btn-primary">إرسال الطلب</button>
    </form>

    <a href="index.php" class="back-link">العودة إلى الصفحة الرئيسية</a>
  </div>

</body>
</html>
