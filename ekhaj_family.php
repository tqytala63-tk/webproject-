<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>بيان قيد عائلي - تصميم مطابق</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="sheet">
    <header class="top">
      <div class="right-block">
        <div class="logo">
          <!-- استخدمت الصورة المرفوعة كعنصر شعار/خلفية -->
          <img src="/mnt/data/923749FB-58C7-41B7-8466-4F2402563C61.jpeg" alt="logo" />
        </div>
      </div>

      <div class="center-block">
        <h1>بَيَان قَيد عائلي</h1>
        <p class="subtitle">الجمهورية اللبنانية — وزارة الداخلية والبلديات</p>
      </div>

      <div class="left-block">
        <div class="qr">QR</div>
      </div>
    </header>

    <main class="content">
      <!-- أعلى جدول بيانات (معلومات السجل) -->
      <table class="main-table">
        <tr class="head-row">
          <th>الرقم</th>
          <td>12345</td>
          <th>المحافظة</th>
          <td>النبطية</td>
          <th>قضاء</th>
          <td>النبطية</td>
        </tr>

        <tr>
          <th>البلدة</th>
          <td>دير الزهراني</td>
          <th>الرقم المتسلسل</th>
          <td>987654</td>
          <th>تاريخ التسجيل</th>
          <td>2019/01/01</td>
        </tr>
      </table>

      <!-- جدول العائلة الكبير -->
      <table class="family-table">
        <thead>
          <tr>
            <th>الاسم الكامل</th>
            <th>الاسم الأب</th>
            <th>الاسم الأم</th>
            <th>تاريخ الولادة</th>
            <th>مكان الولادة</th>
            <th>الجنس</th>
            <th>العلاقة</th>
            <th>ملاحظات</th>
          </tr>
        </thead>

        <tbody>
          <!-- صفوف قابلة للتكرار -->
          <tr>
            <td>محمد علي أحمد</td>
            <td>علي</td>
            <td>فاطمة</td>
            <td>1959/08/14</td>
            <td>دير الزهراني</td>
            <td>ذكر</td>
            <td>رئيس العائلة</td>
            <td></td>
          </tr>

          <tr>
            <td>أحمد محمد علي</td>
            <td>محمد</td>
            <td>ليلى</td>
            <td>1990/05/03</td>
            <td>النبطية</td>
            <td>ذكر</td>
            <td>ابن</td>
            <td></td>
          </tr>

          <tr>
            <td>سلمى محمد علي</td>
            <td>محمد</td>
            <td>ليلى</td>
            <td>1992/07/20</td>
            <td>النبطية</td>
            <td>أنثى</td>
            <td>ابنة</td>
            <td></td>
          </tr>

          <!-- صفوف فارغة إضافية لتطابق المساحة في الصورة -->
          <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        </tbody>
      </table>

      <section class="footer-notes">
        <div class="left-note">
          <p>ختم البلدية</p>
          <div class="stamp-placeholder">ختم</div>
        </div>
        <div class="right-note">
          <p>التوقيع: ____________________</p>
        </div>
      </section>
    </main>
  </div>

  <script src="script.js"></script>
</body>
<style>
    /* عام */
*{box-sizing:border-box}
html,body{height:100%}
body{
  margin:0;
  background:#0A7075; /* نفس خلفية الصورة */
  font-family: "Cairo", "Arial", sans-serif;
  display:flex;
  justify-content:center;
  padding:20px;
}

/* الورقة */
.sheet{
  width: 1000px;
  max-width: 98%;
  background:#fff;
  padding:18px;
  border:1px solid #ddd;
  box-shadow:0 8px 22px rgba(0,0,0,0.15);
  direction:rtl;
}

/* ترويسة */
.top{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:12px;
  border-bottom:1px solid #e6e6e6;
  padding-bottom:10px;
  margin-bottom:12px;
}

.right-block, .left-block{
  width:160px;
  flex:0 0 160px;
  display:flex;
  align-items:center;
  justify-content:center;
}

.logo img{
  width:140px;
  height:110px;
  object-fit:cover;
  border:2px solid #fff;
  background:#fff;
}

/* عنوان مركزي */
.center-block{
  flex:1;
  text-align:center;
}
.center-block h1{
  margin:6px 0 0 0;
  font-size:26px;
  letter-spacing:2px;
}
.center-block .subtitle{
  margin:0;
  font-size:13px;
  color:#444;
}

/* QR مربع */
.qr{
  width:100px;
  height:100px;
  background:#f2f2f2;
  border:1px dashed #ccc;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:700;
  color:#666;
}

/* جدول معلومات السجل */
.main-table{
  width:100%;
  border-collapse:collapse;
  margin-bottom:12px;
}
.main-table th, .main-table td{
  border:1px solid #e8e8e8;
  padding:10px 8px;
  text-align:right;
  vertical-align:middle;
  font-size:14px;
}
.main-table th{
  background:#fafafa;
  font-weight:700;
  width:150px;
}

/* جدول العائلة الكبير */
.family-table{
  width:100%;
  border-collapse:collapse;
  margin-top:6px;
}
.family-table thead th{
  border:1px solid #dcdcdc;
  padding:10px 8px;
  background:#f7f7f7;
  font-weight:700;
  text-align:center;
}
.family-table tbody td{
  border:1px solid #eee;
  padding:10px 6px;
  text-align:right;
  font-size:14px;
  vertical-align:middle;
}
.family-table tbody tr:nth-child(even){ background: #fff; }

/* ملاحظات وتوقيع */
.footer-notes{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-top:14px;
}
.stamp-placeholder{
  width:120px;
  height:60px;
  border:2px solid #d8d8d8;
  display:flex;
  align-items:center;
  justify-content:center;
  background:#fafafa;
  font-weight:700;
}

/* طباعة A4 */
@media print{
  body{background:#fff;padding:0}
  .sheet{box-shadow:none;border:none;width:210mm;height:297mm;padding:18mm;}
  .qr, .stamp-placeholder{border-style:solid}
}

</style>
<script>
    // سهلية التعديل: دوبل-كليك لتعديل أي خلية داخل جدول العائلة
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.family-table tbody td, .main-table td').forEach(td => {
    td.addEventListener('dblclick', () => {
      if (td.isContentEditable) {
        td.contentEditable = 'false';
        td.style.background = '';
      } else {
        td.contentEditable = 'true';
        td.focus();
        td.style.background = '#fffbe6';
      }
    });
  });

  // اختياري: اختزال حجم الخط عند الطباعة كي يطابق الورقة
  window.onbeforeprint = () => { document.body.style.fontSize = '12px'; };
  window.onafterprint = () => { document.body.style.fontSize = ''; };
});

</script>

</html>
