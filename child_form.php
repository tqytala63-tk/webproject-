<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إضافة طفل جديد</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body { 
    font-family:'Cairo',sans-serif; 
    background:#f6fafb; 
    color:#0A7075; 
    margin:0; 
    padding:0;
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
    text-align:center;
    color:#0A7075;
    font-weight:800;
    margin-bottom:30px;
}

form label {
    display:block;
    font-weight:600;
    margin-bottom:5px;
    color:#0A7075;
}

form input, form select {
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:10px;
    margin-bottom:20px;
    font-family:'Cairo',sans-serif;
}

.btn-primary {
    background-color:#0A7075;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:12px;
    font-weight:700;
    cursor:pointer;
    width:100%;
    transition:0.3s;
}

.btn-primary:hover {
    background-color:#095d62;
}

.back-link {
    text-align:center;
    display:block;
    margin-top:20px;
    color:#0A7075;
    text-decoration:none;
}

.back-link:hover {
    text-decoration:underline;
}

@media(max-width:480px){
    .container{
        width:90%;
        margin:40px auto;
    }
}
</style>
</head>
<body>

<div class="container">
    <h2>إضافة طفل جديد</h2>

    <form action="submit_child.php" method="POST">

        <label>الاسم الأول:</label>
        <input type="text" name="FirstName" required>

        <label>الشهرة:</label>
        <input type="text" name="LastName" required>

        <label>اسم الأب:</label>
        <input type="text" name="FatherName" required>

        <label>اسم الأم:</label>
        <input type="text" name="MotherName" required>

        <label>الجنس:</label>
        <select name="Gender" required>
            <option value="M">ذكر</option>
            <option value="F">أنثى</option>
        </select>

        <label>تاريخ الولادة:</label>
        <input type="date" name="DateOfBirth" required>

        <label>مكان القيد:</label>
        <input type="text" name="Hometown" required>

        <button type="submit" class="btn-primary">إصدار شكل جديد</button>

    </form>

    <a href="index.php" class="back-link">العودة إلى الصفحة الرئيسية</a>
</div>

</body>
</html>
