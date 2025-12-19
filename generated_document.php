<?php
session_start();
require 'config.php';

if (!isset($_GET['requestID'])) die("⚠ RequestID مفقود");
$requestID = intval($_GET['requestID']);
if ($requestID <= 0) die("⚠ RequestID غير صالح");

/* =======================
   جلب الطلب
======================= */
$stmt = $pdo->prepare("SELECT * FROM Requests WHERE RequestID = ?");
$stmt->execute([$requestID]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$request) die("⚠ الطلب غير موجود");

/* =======================
   تحقق من الحالة
======================= */
if ($request['Status'] !== 'مقبول') {
    die("<p style='font-family:Cairo;text-align:center'>⚠ لا يمكن عرض المستند، الطلب غير مقبول.</p>");
}

/* =======================
   جلب المواطن
======================= */
$stmt2 = $pdo->prepare("SELECT * FROM citizens WHERE NationalID = ?");
$stmt2->execute([$request['UserID']]);
$citizen = $stmt2->fetch(PDO::FETCH_ASSOC);
if (!$citizen) die("⚠ المواطن غير موجود");

$docType  = trim($request['TransactionType']);
$isAdmin  = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$editable = $isAdmin ? 'contenteditable="true"' : '';

function e($v){
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

/* =======================
   الحقول حسب نوع الوثيقة
======================= */
function renderFields($docType, $citizen, $editable){
    switch ($docType) {

        case 'وثيقة ولادة': ?>
            <tr><th>اسم الطفل</th><td <?= $editable ?>><?= e($citizen['FirstName']) ?></td>
                <th>الشهرة</th><td <?= $editable ?>><?= e($citizen['LastName']) ?></td></tr>

            <tr><th>الجنس</th><td <?= $editable ?>><?= e($citizen['Gender']) ?></td>
                <th>فئة الدم</th><td <?= $editable ?>><?= e($citizen['blood_type']) ?></td></tr>

            <tr><th>محل وتاريخ الولادة</th>
                <td <?= $editable ?>><?= e($citizen['Hometown'].' - '.$citizen['DateOfBirth']) ?></td>
                <th>الرقم الوطني</th><td <?= $editable ?>><?= e($citizen['NationalID']) ?></td></tr>

            <tr><th>اسم الأب</th><td <?= $editable ?>><?= e($citizen['FatherName']) ?></td>
                <th>اسم الأم</th><td <?= $editable ?>><?= e($citizen['MotherName']) ?></td></tr>
        <?php break;

        case 'بطاقة الهوية': ?>
            <tr><th>الاسم الكامل</th><td <?= $editable ?>><?= e($citizen['FirstName'].' '.$citizen['LastName']) ?></td>
                <th>الجنس</th><td <?= $editable ?>><?= e($citizen['Gender']) ?></td></tr>

            <tr><th>اسم الأب</th><td <?= $editable ?>><?= e($citizen['FatherName']) ?></td>
                <th>اسم الأم</th><td <?= $editable ?>><?= e($citizen['MotherName']) ?></td></tr>

            <tr><th>تاريخ الولادة</th><td <?= $editable ?>><?= e($citizen['DateOfBirth']) ?></td>
                <th>محل الولادة</th><td <?= $editable ?>><?= e($citizen['Hometown']) ?></td></tr>

            <tr><th>الرقم الوطني</th><td <?= $editable ?>><?= e($citizen['NationalID']) ?></td>
                <th>فئة الدم</th><td <?= $editable ?>><?= e($citizen['blood_type']) ?></td></tr>
        <?php break;

        case 'إخراج قيد فردي': ?>
            <tr><th>الاسم الكامل</th><td <?= $editable ?>><?= e($citizen['FirstName'].' '.$citizen['LastName']) ?></td></tr>
            <tr><th>اسم الأب</th><td <?= $editable ?>><?= e($citizen['FatherName']) ?></td></tr>
            <tr><th>اسم الأم</th><td <?= $editable ?>><?= e($citizen['MotherName']) ?></td></tr>
            <tr><th>الرقم الوطني</th><td <?= $editable ?>><?= e($citizen['NationalID']) ?></td></tr>
            <tr><th>القضاء</th><td <?= $editable ?>><?= e($citizen['District']) ?></td></tr>
            <tr><th>المحافظة</th><td <?= $editable ?>><?= e($citizen['Governorate']) ?></td></tr>
        <?php break;

        case 'إخراج قيد عائلي': ?>
            <tr>
                <th>اسم رب العائلة</th>
                <td><?= e($citizen['FatherName']) ?></td>
                <th>شهرة العائلة</th>
                <td><?= e($citizen['LastName']) ?></td>
            </tr>
            <tr>
                <th>اسم الزوجة</th>
                <td><?= e($citizen['MotherName']) ?></td>
                <th>عدد الأولاد</th>
                <td><?= e($citizen['ChildrenCount'] ?? '') ?></td>
            </tr>
            <tr>
                <th>الرقم الوطني</th>
                <td><?= e($citizen['NationalID']) ?></td>
                <th>القضاء</th>
                <td><?= e($citizen['District']) ?></td>
            </tr>
            <tr>
                <th>القرية</th>
                <td><?= e($citizen['Hometown']) ?></td>
                <th>المحافظة</th>
                <td><?= e($citizen['Governorate']) ?></td>
            </tr>
        <?php break;

        case 'وثيقة زواج': ?>
            <tr>
                <th>اسم الزوج</th><td><?= e($citizen['FirstName']) ?></td>
                <th>شهرة الزوج</th><td><?= e($citizen['LastName']) ?></td>
            </tr>
            <tr>
                <th>اسم الزوجة</th><td><?= e($citizen['SpouseName'] ?? '') ?></td>
                <th>شهرة الزوجة</th><td><?= e($citizen['SpouseLastName'] ?? '') ?></td>
            </tr>
            <tr>
                <th>تاريخ الزواج</th><td><?= e($citizen['MarriageDate'] ?? '') ?></td>
                <th>مكان الزواج</th><td><?= e($citizen['MarriagePlace'] ?? '') ?></td>
            </tr>
            <tr>
                <th>الرقم الوطني</th><td><?= e($citizen['NationalID']) ?></td>
                <th>القضاء</th><td><?= e($citizen['District']) ?></td>
            </tr>
        <?php break;

        case 'وثيقة وفاة': ?>
            <tr><th>اسم المتوفي</th><td <?= $editable ?>><?= e($citizen['FirstName'].' '.$citizen['LastName']) ?></td>
                <th>تاريخ الوفاة</th><td <?= $editable ?>><?= e($citizen['DeathDate']) ?></td></tr>
            <tr><th>محل الوفاة</th><td <?= $editable ?>><?= e($citizen['DeathPlace']) ?></td>
                <th>الرقم الوطني</th><td <?= $editable ?>><?= e($citizen['NationalID']) ?></td></tr>
        <?php break;

        default:
            echo "<tr><td colspan='4'>⚠ نوع الوثيقة غير معروف</td></tr>";
    }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title><?= e($docType) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
<style>
body{
    font-family:Cairo;
    background:#0A7075;
    padding:24px;
    display:flex;
    justify-content:center;
}
.paper{
    background:#fff;
    width:900px;
    max-width:95%;
    padding:20px;
    box-shadow:0 8px 25px rgba(0,0,0,.2);
}
.header{
    display:flex;
    gap:16px;
    border-bottom:1px solid #ddd;
    padding-bottom:12px;
}
.logo-area{width:140px}
.photo{
    width:140px;
    height:170px;
    object-fit:cover;
    border:4px solid #eee;
}
.title-area{text-align:center;flex:1}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th,td{
    border:1px solid #ddd;
    padding:12px;
}
th{
    background:#f7f7f7;
    width:170px;
}
td[contenteditable]{
    background:#fffbe6;
}
.footer{
    display:flex;
    justify-content:space-between;
    margin-top:25px;
}
button{
    margin-top:20px;
    padding:10px 18px;
    background:#0A7075;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}
@media print{
    button{display:none}
    body{background:white}
}
</style>
</head>

<body>
<div class="paper" id="printArea">

<header class="header">
    <div class="logo-area">
        <img src="logo.jpg" class="photo">
    </div>
    <div class="title-area">
        <h2><?= e($docType) ?></h2>
        <p>الجمهورية اللبنانية – دائرة النفوس</p>
        <p>رقم الطلب: <?= $requestID ?> | تاريخ: <?= e($request['RequestDate']) ?></p>
    </div>
</header>

<table>
    <?php renderFields($docType, $citizen, $editable); ?>
</table>

<?php if($isAdmin): ?>
<form method="POST" action="accept_request.php">
    <input type="hidden" name="requestID" value="<?= $requestID ?>">
    <button type="submit">إنشاء</button>
</form>
<?php endif; ?>

<div class="footer">
    <div class="stamp">ختم المختار</div>
    <div class="sign">التوقيع: __________</div>
</div>

<!-- زر Print / Download PDF -->
<div style="text-align:center; margin-top:20px;">
    <button onclick="window.print()">🖨️ طباعة</button>
    <button onclick="downloadDiv()" id="print_Button">Download PDF</button>
</div>

</div>

<!-- سكريبت html2pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script type="text/javascript">
function downloadDiv() {
    var element = document.getElementById('printArea');
    var opt = {
        margin:       0.5,
        filename:     'report.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
}
</script>
</body>
</html>
