<!doctype html>
<html lang="ar">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>إخراج القيد</title>
<style>
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #f0f2f5;
  display:flex;
  justify-content:center;
  padding:40px 20px;
}

.card {
  background:white;
  width:600px;
  padding:30px 40px;
  border-radius:12px;
  box-shadow:0 5px 20px rgba(0,0,0,0.15);
  border:1px solid #e0e0e0;
}

h1 {
  text-align:center;
  color:#1e3a8a;
  margin-bottom:25px;
  font-size:26px;
  letter-spacing:1px;
}

.row {
  display:flex;
  justify-content:space-between;
  margin-bottom:15px;
  padding-bottom:5px;
  border-bottom:1px dashed #ddd;
}

.label {
  font-weight:bold;
  color:#333;
}

.value {
  text-align:right;
  color:#555;
}

.qr-row {
  display:flex;
  justify-content:flex-start;
  align-items:center;
  margin-top:25px;
}

.qr {
  width:90px;
  height:90px;
  background:white;
  border:1px solid #ccc;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-left:15px;
  font-size:10px;
  box-shadow:0 2px 5px rgba(0,0,0,0.1);
  color:#888;
}

.signature {
  display:flex;
  justify-content:space-between;
  margin-top:35px;
}

.sig-box {
  width:45%;
  border-top:1px solid #aaa;
  padding-top:5px;
  text-align:center;
  font-size:13px;
  color:#444;
}

.footer {
  text-align:center;
  font-size:12px;
  margin-top:30px;
  color:#888;
  letter-spacing:0.5px;
}
</style>
</head>
<body>
<div class="card">
  <h1>إخراج القيد</h1>

  <div class="row">
    <div class="label">الاسم الكامل:</div><div class="value">محمد علي أحمد</div>
  </div>
  <div class="row">
    <div class="label">اسم الأب:</div><div class="value">بلال</div>
  </div>
  <div class="row">
    <div class="label">تاريخ الميلاد:</div><div class="value">01/01/1990</div>
  </div>
  <div class="row">
    <div class="label">مكان الميلاد:</div><div class="value">بيروت</div>
  </div>
  <div class="row">
    <div class="label">رقم القيد:</div><div class="value">123456</div>
  </div>
  <div class="row">
    <div class="label">نوع القيد:</div><div class="value">فردي / عائلي</div>
  </div>
  <div class="row">
    <div class="label">تاريخ الإصدار:</div><div class="value">19/11/2025</div>
  </div>

  <div class="qr-row">
    <div class="label">التحقق عبر QR:</div>
    <div class="qr">QR CODE</div>
  </div>

  <div class="signature">
    <div class="sig-box">ختم الإدارة</div>
    <div class="sig-box">توقيع الموظف</div>
  </div>

  <div class="footer">المديرية العامة للأحوال الشخصية – وزارة الداخلية والبلديات</div>
</div>
</body>
</html>
