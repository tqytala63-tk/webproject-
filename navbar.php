<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>بوابة الخدمات</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <style>
    :root {
      --accent: #0A7075;
      --muted: #6c757d;
      --bg: #ffffff;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; scroll-behavior: smooth; }
    body {
      font-family: 'Cairo', sans-serif;
      background: #f9f9f9;
      direction: rtl;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 60px;
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      position: fixed;
      top: 0;
      width: 100%;
      left: 0;
      z-index: 100;
    }

    /* Brand */
    .brand {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logo {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      background: linear-gradient(135deg, #0A7075, #47b6b9);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: 700;
      font-size: 20px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.1);
    }

    .brand h1 {
      font-size: 18px;
      font-weight: 700;
      color: var(--accent);
      margin: 0;
    }

    /* Nav Links */
    .nav-links {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 35px;
      flex: 1;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--muted);
      font-weight: 600;
      font-size: 16px;
      transition: color 0.3s ease;
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: var(--accent);
    }

    /* Buttons */
    .auth-buttons {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .btn-outline,
    .btn-primary {
      padding: 9px 20px;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: 0.3s;
      font-size: 15px;
    }

    .btn-outline {
      border: 1px solid var(--accent);
      color: var(--accent);
      background: transparent;
    }

    .btn-outline:hover {
      background-color: var(--accent);
      color: #fff;
    }

    .btn-primary {
      background-color: var(--accent);
      color: #fff;
      box-shadow: 0 5px 15px rgba(10,112,117,0.2);
    }

    .btn-primary:hover {
      background-color: #095d62;
    }

    /* Mobile Menu */
    .menu-toggle {
      display: none;
      font-size: 22px;
      color: var(--accent);
      cursor: pointer;
    }

    @media (max-width: 900px) {
      .nav-links,
      .auth-buttons {
        display: none;
      }

      .menu-toggle {
        display: block;
      }

      .mobile-menu {
        display: none;
        position: absolute;
        top: 80px;
        right: 0;
        width: 100%;
        background-color: #fff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        flex-direction: column;
        text-align: center;
        padding: 15px 0;
        z-index: 99;
      }

      .mobile-menu a {
        display: block;
        padding: 12px 0;
        text-decoration: none;
        color: var(--muted);
        font-weight: 600;
      }

      .mobile-menu a:hover {
        color: var(--accent);
      }

      .mobile-menu.show {
        display: flex;
      }
    }
  </style>
</head>
<body>
  


  <header class="navbar">
    <div class="brand">
      <div class="logo">
  <img src="./logo.jpg" alt="Logo" style="width:100%; height:100%; border-radius:12px; object-fit:cover;">
</div>

      <h1>بوابة الخدمات</h1>
    </div>
<nav class="nav-links">
  <a href="index.php" class="active">الرئيسية</a>
  <a href="about.php">من نحن</a>
  <a href="index.php#services">المعاملات</a>
   <a href="./citizen_requests.php">طلبات</a>

  <?php
 
  if (isset($_SESSION["role"]) && $_SESSION["role"] == 'admin') {
      echo '<a href="dashboard.php">لوحة التحكم</a>';
  }
  ?>

  <a href="logout.php">تسجيل خروج</a>
</nav>


    <div class="auth-buttons">
      <a href="login.php" class="btn-outline">تسجيل الدخول</a>
      <a href="./register_citizen.php" class="btn-primary">إنشاء حساب</a>
    </div>

    <div class="menu-toggle" id="menuToggle"><i class="fa-solid fa-bars"></i></div>
  </header>



  <script>
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('show');
    });
  </script>

</body>
</html>
