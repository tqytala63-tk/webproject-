<?php
function getLastChildNationalID($conn, $fatherName) {
    $stmt = $conn->prepare("SELECT NationalID FROM citizens WHERE FatherName = ? ORDER BY CitizenID DESC LIMIT 1");
    $stmt->execute([$fatherName]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        return $row['NationalID'];
    }

    return null; // No children before
}
?>