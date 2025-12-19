<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>وثيقة زواج – نموذج</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body {
  font-family: 'Cairo', Arial, sans-serif;
  background: #0A7075;
  padding: 24px;
  display: flex;
  justify-content: center;
}
.paper {
  background: #fff;
  width: 900px;
  max-width: 95%;
  padding: 20px;
  border: 1px solid #ddd;
  box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
.header {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  padding-bottom: 12px;
  border-bottom: 1px solid #e6e6e6;
}
.logo-area { width: 140px; }
.photo { width: 140px; height: 170px; object-fit: cover; border: 4px solid #f3f3f3; }
.title-area { flex: 1; text-align: center; }
.title-area h1 { margin: 6px 0; font-size: 28px; }
.title-area .sub { margin: 0; font-size: 13px; color: #555; }
.qr-area { width: 120px; display: flex; justify-content: center; align-items: center; }
.qr-placeholder { width: 90px; height: 90px; background: #eee; border: 1px dashed #ccc; display: flex; justify-content: center; align-items: center; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; }
th, td { padding: 12px; border: 1px solid #e8e8e8; }
th { background: #fafafa; width: 160px; font-weight: bold; }
.notes { margin-top: 18px; padding: 12px; border: 1px dashed #e0e0e0; background: #fbfbfb; }
.footer { display: flex; justify-content: space-between; margin-top: 20px; }
.stamp { padding: 10px 18px; border: 2px solid #e0e0e0; background: #f9f9f9; font-weight: bold; }
.sign { font-size: 14px; }
</style>
</head>
<body>
<div class="paper">
  <header class="header">
    <div class="logo-area">
      <img src="person.jpg" alt="photo" class="photo">
    </div>
    <div class="title-area">
      <h1>وثيقة زواج</h1>
      <p class="sub">الجمهورية اللبنانية – وزارة الداخلية والبلديات</p>
    </div>
    <div class="qr-area">
      <div class="qr-placeholder">QR</div>
    </div>
  </header>

  <main class="main-table">
    <table>
      <tr><th>اسم الزوج</th><td>محمد</td><th>شهرة الزوج</th><td>أحمد</td></tr>
      <tr><th>اسم الأب</th><td>علي</td><th>اسم الأم وشهرتها</th><td>فاطمة حسين</td></tr>
      <tr><th>محل الولادة</th><td>بيروت</td><th>تاريخ الولادة</th><td>1990/01/01</td></tr>
      <tr><th>اسم الزوجة</th><td>ليلى</td><th>شهرة الزوجة</th><td>حسين</td></tr>
      <tr><th>اسم الأب</th><td>سعيد</td><th>اسم الأم وشهرتها</th><td>فاطمة علي</td></tr>
      <tr><th>محل الولادة</th><td>صيدا</td><th>تاريخ الولادة</th><td>1992/03/05</td></tr>
      <tr><th>تاريخ الزواج</th><td>2025/11/22</td><th>رقم السجل</th><td>987654</td></tr>
      <tr><th>القرية</th><td>عين عنوب</td><th>القضاء</th><td>متن</td></tr>
      <tr><th>المحافظة</th><td>لبنان</td><th>اسم الشاهدين</th><td>أحمد – علي</td></tr>
      <tr><th>المأذون / الكاتب العدل</th><td colspan="3">حسن محمود</td></tr>
    </table>

    <section class="notes">
      <h3>ملاحظات</h3>
      <p>هذا تصميم مشابه للنموذج الرسمي.</p>
    </section>
  </main>

  <footer class="footer">
    <div class="stamp">ختم المختار</div>
    <div class="sign">التوقيع: ____________</div>
  </footer>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("td").forEach(td => {
    td.addEventListener("dblclick", () => {
      if (td.isContentEditable) {
        td.contentEditable = "false";
        td.style.background = "";
      } else {
        td.contentEditable = "true";
        td.style.background = "#fffbe6";
        td.focus();
      }
    });
  });
});
</script>
</body>
</html>
