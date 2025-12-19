<?php
session_start();
require 'config.php';
header('Content-Type: application/json');

$userID = $_SESSION['user_id'] ?? null;

if(!$userID){
    echo json_encode(['success'=>false, 'message'=>'يجب تسجيل الدخول أولا']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$transactionType = trim($input['transactionType'] ?? '');

if(!$transactionType){
    echo json_encode(['success'=>false, 'message'=>'نوع المعاملة غير محدد']);
    exit;
}

// إضافة الطلب مباشرة
$stmt = $pdo->prepare("INSERT INTO Requests (UserID, TransactionType, Status, RequestDate) VALUES (?, ?, 'قيد المعالجة', NOW())");
if($stmt->execute([$userID, $transactionType])){
    echo json_encode(['success'=>true]);
}else{
    echo json_encode(['success'=>false, 'message'=>'فشل تسجيل الطلب']);
}
