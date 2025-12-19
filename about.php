<?php
require 'config.php';
$no_header = false;
?>

<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>من نحن - بوابة الخدمات الحكومية الإلكترونية</title>

  <!-- الخطوط والأيقونات -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <style>
    :root{
      --accent:#0A7075;
      --bg:#f7fafc;
      --shadow:0 6px 18px rgba(10,112,117,0.12);
    }

    body{
      margin:0;
      font-family:'Cairo',sans-serif;
      background:var(--bg);
      color:#0f172a;
    }

    /* HERO */
    .hero{
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:center;
      text-align:center;
      padding:120px 20px;
      background:linear-gradient(180deg,#ffffff 0%, #eef7f7 100%);
      min-height:400px;
    }
    .hero h2{
      font-size:48px;
      font-weight:800;
      color:var(--accent);
      margin-bottom:20px;
    }
    .hero p{
      font-size:20px;
      max-width:800px;
      margin:0 auto;
      color:#444;
      line-height:1.7;
    }

    /* CONTAINER */
    .container{
      max-width:1100px;
      margin:auto;
      padding:60px 20px;
    }

    /* BOXES العامة */
    .info-box{
      border-radius:18px;
      padding:50px 40px;
      margin-bottom:50px;
    }

    /* رؤيتنا و رسالتنا */
    .vision-mission{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(400px,1fr));
      gap:30px;
    }
    .mini-box{
      border-radius:15px;
      padding:40px 30px;
      text-align:center;
      transition:transform 0.3s ease;
      background:transparent;
    }
    .mini-box:hover{
      transform:translateY(-5px);
    }
    .mini-box h3{
      font-size:26px;
      color:var(--accent);
      margin-bottom:15px;
      font-weight:800;
    }
    .mini-box p{
      font-size:17px;
      color:#444;
      line-height:1.8;
    }

    /* قيمنا */
    .values{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(400px,1fr));
      gap:30px;
    }
    .value-box{
      background:#ffffff;
      border-radius:15px;
      box-shadow:var(--shadow);
      padding:45px 30px;
      text-align:center;
      transition:0.3s;
    }
    .value-box:hover{transform:translateY(-6px);}
    .value-box .icon{
      font-size:42px;
      color:var(--accent);
      margin-bottom:15px;
    }
    .value-box h4{
      color:var(--accent);
      font-size:22px;
      font-weight:700;
      margin-bottom:10px;
    }
    .value-box p{
      color:#555;
      font-size:16px;
      line-height:1.6;
    }

    /* إنجازاتنا */
    .stats{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
      gap:25px;
      margin-top:40px;
    }
    .stat-box{
      background:var(--accent);
      color:white;
      border-radius:15px;
      padding:30px 15px;
      box-shadow:var(--shadow);
      transition:transform 0.3s ease;
    }
    .stat-box:hover{transform:translateY(-6px);}
    .stat-box h2{
      font-size:2rem;
      margin-bottom:10px;
    }

    footer{
      text-align:center;
      padding:40px 20px;
      color:#555;
      background:#f1f5f5;
      margin-top:80px;
    }
  </style>
</head>
<body>

  <?php include 'navbar.php'; ?>

  <main>
    <!-- قسم المقدمة -->
    <section class="hero">
      <h2>من نحن</h2>
      <p>نحن منصة إلكترونية حكومية رائدة تهدف إلى تسهيل الحصول على الخدمات الحكومية للمواطنين.</p>
    </section>

    <div class="container">
      <!-- رؤيتنا و رسالتنا -->
      <div class="info-box vision-mission">
        <div class="mini-box">
          <h3>رؤيتنا</h3>
          <p>أن نكون المنصة الإلكترونية الأولى والأكثر موثوقية في تقديم الخدمات الحكومية، ونساهم في التحول الرقمي الشامل للخدمات الحكومية.</p>
        </div>

        <div class="mini-box">
          <h3>رسالتنا</h3>
          <p>تقديم خدمات حكومية إلكترونية متميزة تتسم بالسرعة والدقة والأمان، مع ضمان سهولة الوصول لجميع المواطنين وتوفير تجربة استخدام سلسة ومريحة.</p>
        </div>
      </div>

      <!-- قيمنا -->
      <div class="info-box">
        <h2 style="text-align:center;color:var(--accent);font-weight:800;margin-bottom:40px;">قيمنا</h2>
        <div class="values">
          <div class="value-box">
            <div class="icon"><i class="fa-solid fa-star"></i></div>
            <h4>الجودة</h4>
            <p>نسعى دائماً لتقديم أعلى مستويات الجودة في خدماتنا.</p>
          </div>

          <div class="value-box">
            <div class="icon"><i class="fa-solid fa-scale-balanced"></i></div>
            <h4>الشفافية</h4>
            <p>نؤمن بالشفافية الكاملة في جميع تعاملاتنا.</p>
          </div>

          <div class="value-box">
            <div class="icon"><i class="fa-solid fa-lightbulb"></i></div>
            <h4>الابتكار</h4>
            <p>نبتكر حلولاً تقنية متطورة لخدمة المواطنين.</p>
          </div>

          <div class="value-box">
            <div class="icon"><i class="fa-solid fa-shield-halved"></i></div>
            <h4>الأمان</h4>
            <p>نحمي بياناتك بأعلى معايير الأمان الإلكتروني.</p>
          </div>
        </div>
      </div>

      <!-- إنجازاتنا -->
      <div class="info-box">
        <h2 style="text-align:center;color:var(--accent);font-weight:800;margin-bottom:40px;">إنجازاتنا</h2>
        <div class="stats">
          <div class="stat-box">
            <h2 id="users">+50,000</h2>
            <p>مستخدم نشط</p>
          </div>
          <div class="stat-box">
            <h2 id="transactions">+100,000</h2>
            <p>معاملة منجزة</p>
          </div>
          <div class="stat-box">
            <h2 id="services">6</h2>
            <p>خدمات متاحة</p>
          </div>
          <div class="stat-box">
            <h2 id="support">24/7</h2>
            <p>دعم فني متواصل</p>
          </div>
        </div>
      </div>
    </div>
  </main>

  

  <!-- JS لزيادة الأرقام -->
  <script>
    const stats = [
      { id: "users", start: 0, end: 50000 },
      { id: "transactions", start: 0, end: 100000 },
      { id: "services", start: 0, end: 6 },
    ];

    stats.forEach(stat => {
      const el = document.getElementById(stat.id);
      let current = stat.start;
      const increment = stat.end / 100;

      const counter = setInterval(() => {
        current += increment;
        if (current >= stat.end) {
          current = stat.end;
          clearInterval(counter);
        }
        el.textContent = "+" + Math.floor(current).toLocaleString();
      }, 30);
    });
  </script>
<?php include 'footer.php'; ?>

</body>
</html>
