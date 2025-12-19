<?php
require_once "config.php"; // الاتصال جاهز

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstName   = $_POST["FirstName"];
    $lastName    = $_POST["LastName"];
    $fatherName  = $_POST["FatherName"];
    $motherName  = $_POST["MotherName"];
    $gender      = $_POST["Gender"];
    $dob         = $_POST["DateOfBirth"];
    $hometown    = $_POST["Hometown"];

    function getLastChildNationalID($pdo, $fatherName) {
        $stmt = $pdo->prepare("SELECT NationalID FROM citizens WHERE FatherName = ? ORDER BY CitizenID DESC LIMIT 1");
        $stmt->execute([$fatherName]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            return $row['NationalID'];
        }
        return null;
    }

    function generateNewNationalID($lastID) {
        if ($lastID === null || $lastID === "") {
            return "100000";
        } else {
            return strval(intval($lastID) + 1);
        }
    }

    $lastID = getLastChildNationalID($pdo, $fatherName);
    $newNationalID = generateNewNationalID($lastID);

    $insert = $pdo->prepare("
        INSERT INTO citizens (NationalID, FirstName, LastName, FatherName, MotherName, Gender, DateOfBirth, Hometown)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $insert->execute([
        $newNationalID,
        $firstName,
        $lastName,
        $fatherName,
        $motherName,
        $gender,
        $dob,
        $hometown
    ]);
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>إصدار شكل جديد</title>
<style>
body {
    font-family: 'Cairo', sans-serif;
    background-color: #f6fafb;
    color: #0A7075;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.box {
    background-color: #fff;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(10,112,117,0.15);
    max-width: 500px;
    width: 90%;
}

.box h3 {
    color: #0A7075;
    font-weight: 800;
    margin-bottom: 20px;
}

.box p {
    font-size: 16px;
    color: #333;
    margin-bottom: 20px;
}

.box a {
    display: inline-block;
    color: #0A7075;
    text-decoration: none;
    font-weight: 600;
    border: 1px solid #0A7075;
    padding: 10px 20px;
    border-radius: 10px;
    transition: 0.3s;
}

.box a:hover {
    background-color: #0A7075;
    color: #fff;
}
</style>
</head>
<body>
<div class="box">
    <h3>✔️ تم إصدار الشكل الجديد بنجاح!</h3>
    <p><strong>الرقم القومي للطفل:</strong> <?= $newNationalID ?></p>
    <a href="child_form.php">رجوع</a>
</div>
</body>
</html>
