<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>بيان قيد – نموذج</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="paper">
    <header class="header">
      <div class="logo-area">
        <img src="person.jpg" alt="photo" class="photo">
      </div>

      <div class="title-area">
        <h1>بَيَان قَيد إفرادي</h1>
        <p class="sub">الجمهورية اللبنانية – وزارة الداخلية والبلديات</p>
      </div>

      <div class="qr-area">
        <div class="qr-placeholder">QR</div>
      </div>
    </header>

    <main class="main-table">
      <table>
        <tr>
          <th>الاسم الكامل</th>
          <td>محمد علي أحمد</td>
          <th>اسم الأب</th>
          <td>علي أحمد</td>
        </tr>

        <tr>
          <th>اسم الأم</th>
          <td>فاطمة حسين</td>
          <th>مكان وتاريخ الولادة</th>
          <td>بيروت - 1990/01/01</td>
        </tr>

        <tr>
          <th>الجنس</th>
          <td>ذكر</td>
          <th>الديانة</th>
          <td>مسلم</td>
        </tr>

        <tr>
          <th>الحالة</th>
          <td>سليم</td>
          <th>الوضع العائلي</th>
          <td>أعزب</td>
        </tr>
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

  <script src="script.js"></script>
</body>
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

.logo-area {
  width: 140px;
}

.photo {
  width: 140px;
  height: 170px;
  object-fit: cover;
  border: 4px solid #f3f3f3;
}

.title-area {
  flex: 1;
  text-align: center;
}

.title-area h1 {
  margin: 6px 0;
  font-size: 28px;
}

.title-area .sub {
  margin: 0;
  font-size: 13px;
  color: #555;
}

.qr-area {
  width: 120px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.qr-placeholder {
  width: 90px;
  height: 90px;
  background: #eee;
  border: 1px dashed #ccc;
  display: flex;
  justify-content: center;
  align-items: center;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

th, td {
  padding: 12px;
  border: 1px solid #e8e8e8;
}

th {
  background: #fafafa;
  width: 160px;
  font-weight: bold;
}

.notes {
  margin-top: 18px;
  padding: 12px;
  border: 1px dashed #e0e0e0;
  background: #fbfbfb;
}

.footer {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.stamp {
  padding: 10px 18px;
  border: 2px solid #e0e0e0;
  background: #f9f9f9;
  font-weight: bold;
}

.sign {
  font-size: 14px;
}
</style>
><script>
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

</html>
