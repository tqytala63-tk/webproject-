<?php
session_start();
require 'config.php';
$errors = [];
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $national = trim($_POST['national'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // التحقق من الحقول المطلوبة
    if (!$fullname || !$national || !$email || !$password) {
        $errors[] = "الرجاء تعبئة جميع الحقول المطلوبة.";
    }

    if (empty($errors)) {
        // تحقق إذا الرقم موجود بالـ Citizens
        $stmtCitizen = $pdo->prepare("SELECT NationalID FROM Citizens WHERE NationalID = ?");
        $stmtCitizen->execute([$national]);

        if (!$stmtCitizen->fetch()) {
            $errors[] = "رقمك الوطني غير مسجل مسبقاً.";
        } else {
            // تحقق إذا الرقم موجود بالـ users
            $stmt = $pdo->prepare("SELECT UserID FROM users WHERE UserID = ?");
            $stmt->execute([$national]);

            if ($stmt->fetch()) {
                $errors[] = "هذا الرقم الوطني مسجل مسبقاً، يرجى تسجيل الدخول.";
            } else {
                // كل شيء تمام → نعمل INSERT بالـ UserID = NationalID
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = $pdo->prepare("INSERT INTO users (UserID, FullName, Email, PasswordHash, Phone, Address) VALUES (?, ?, ?, ?, ?,?)");
                
                try {
                    $ins->execute([$national, $fullname, $email, $hash, $phone, $address]);
                    $success_msg = "تم التحقق والتسجيل بنجاح.";
                    // يمكن توجيه المستخدم مباشرة للـ login إذا بدك
                    header("Location: login.php");
                    exit;
                } catch (PDOException $e) {
                    $errors[] = "حدث خطأ أثناء التسجيل: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل حساب جديد</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    :root { --accent: #0A7075; --muted: #6c757d; --bg: #f4f8f9; }
    body { margin:0;font-family:'Cairo',sans-serif;background-color:var(--bg);}
    .register-container{width:450px;margin:120px auto;background:#fff;border-radius:14px;box-shadow:0 5px 18px rgba(0,0,0,.1);padding:35px;text-align:center;}
    .register-container h2{color:var(--accent);margin-bottom:25px;font-weight:800;}
    .register-container label{display:block;text-align:right;color:var(--muted);font-weight:600;margin-bottom:6px;}
    .register-container input{width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-bottom:18px;font-size:15px;}
    .btn-primary.full{background-color:var(--accent);color:#fff;border:none;padding:12px 0;border-radius:10px;font-weight:700;font-size:16px;width:100%;cursor:pointer;transition:background 0.3s ease;}
    .btn-primary.full:hover{background-color:#095d62;}
    .alert-danger{background-color:#f8d7da;color:#842029;padding:10px;border-radius:8px;margin-bottom:15px;font-weight:600;text-align:center;}
    .alert-success{background-color:#d1e7dd;color:#0f5132;padding:10px;border-radius:8px;margin-bottom:15px;font-weight:600;text-align:center;}
    @media(max-width:480px){.register-container{width:90%;margin:100px auto;}}
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="register-container">
  <h2>تسجيل حساب جديد</h2>

  <?php if ($errors): ?>
    <div class="alert-danger">
      <?php foreach ($errors as $e) echo "<div>" . htmlspecialchars($e) . "</div>"; ?>
    </div>
  <?php endif; ?>

  <?php if ($success_msg): ?>
    <div class="alert-success">
      <?php echo htmlspecialchars($success_msg); ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <label>الاسم الكامل</label>
    <input type="text" name="fullname" required>

    <label>الرقم الوطني</label>
    <input type="text" name="national" required>

    <label>البريد الإلكتروني</label>
    <input type="email" name="email" required>

    <label>كلمة المرور</label>
    <input type="password" name="password" required>

    <label>رقم الهاتف</label>
    <input type="text" name="phone">

    <label>العنوان</label>
    <input type="text" name="address">

    <button type="submit" class="btn-primary full">إنشاء حساب</button>
  </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
