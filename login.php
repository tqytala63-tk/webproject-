<?php
session_start();
require 'config.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $national = trim($_POST['national'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$national || !$password) {
        $errors[] = "الرجاء تعبئة جميع الحقول.";
    } else {
      
        $stmt = $pdo->prepare("SELECT UserID, PasswordHash, FullName,Role  FROM users WHERE UserID = ?");
        $stmt->execute([$national]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['PasswordHash'])) {
     
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['fullname'] = $user['FullName'];  
             $_SESSION['role'] = $user['Role'];



            header("Location: index.php");
            exit;
        } else {
            $errors[] = "رقمك الوطني أو كلمة المرور غير صحيحة.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تسجيل الدخول</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --accent: #0A7075; --muted: #6c757d; --bg: #f4f8f9; }
body { margin:0;font-family:'Cairo',sans-serif;background-color:var(--bg);}
.login-container{width:400px;margin:120px auto;background:#fff;border-radius:14px;box-shadow:0 5px 18px rgba(0,0,0,.1);padding:35px;text-align:center;}
.login-container h2{color:var(--accent);margin-bottom:25px;font-weight:800;}
.login-container label{display:block;text-align:right;color:var(--muted);font-weight:600;margin-bottom:6px;}
.login-container input{width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-bottom:18px;font-size:15px;}
.btn-primary.full{background-color:var(--accent);color:#fff;border:none;padding:12px 0;border-radius:10px;font-weight:700;font-size:16px;width:100%;cursor:pointer;transition:background 0.3s ease;}
.btn-primary.full:hover{background-color:#095d62;}
.alert-danger{background-color:#f8d7da;color:#842029;padding:10px;border-radius:8px;margin-bottom:15px;font-weight:600;text-align:center;}
@media(max-width:480px){.login-container{width:90%;margin:100px auto;}}
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="login-container">
  <h2>تسجيل الدخول</h2>

  <?php if ($errors): ?>
    <div class="alert-danger">
      <?php foreach ($errors as $e) echo "<div>" . htmlspecialchars($e) . "</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <label>الرقم الوطني</label>
    <input type="text" name="national" required>

    <label>كلمة المرور</label>
    <input type="password" name="password" required>

    <button type="submit" class="btn-primary full">تسجيل الدخول</button>
  </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
