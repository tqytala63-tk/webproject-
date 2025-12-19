<?php
session_start();
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$nationalID = $data['nationalID'] ?? '';

$response = ['requests'=>[], 'error'=>''];

if($nationalID){
    // تحقق من وجود المواطن
    $stmt = $pdo->prepare("SELECT * FROM Citizens WHERE NationalID=?");
    $stmt->execute([$nationalID]);
    $citizen = $stmt->fetch(PDO::FETCH_ASSOC);

    if($citizen){
        $stmt2 = $pdo->prepare("
            SELECT RequestID, TransactionType, Status, RequestDate
            FROM requests
            WHERE UserID = ?
            ORDER BY RequestDate DESC
        ");
        $stmt2->execute([$nationalID]);
        $requests = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $response['requests'] = $requests;
    } else {
        $response['error'] = "هذا الرقم الوطني غير موجود!";
    }
} else {
    $response['error'] = "الرجاء إدخال الرقم الوطني";
}

header('Content-Type: application/json');
echo json_encode($response);
