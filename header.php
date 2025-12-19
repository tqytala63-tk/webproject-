<?php
if (!isset($no_header)) { // تقدر تعدلي لعدم اظهار الهيدر ببعض الصفحات
?>
<div class="navbar">
  <div class="brand">بوابة الخدمات</div>
  <nav>
    <a href="index.php">الرئيسية</a>
    <a href="services.php">الخدمات</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="dashboard.php">لوحة التحكم</a>
      <a href="logout.php">تسجيل الخروج</a>
    <?php else: ?>
      <a href="login.php">تسجيل الدخول</a>
      <a href="./register_citizen.php" class="btn btn-primary" style="padding:8px 12px;">إنشاء حساب</a>
    <?php endif; ?>
  </nav>
</div>
<?php } ?>
