<?php
session_start();
require 'config.php';

// تأكد من أن المستخدم أدمن
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo json_encode(['success'=>false]);
    exit;
}

// جلب البيانات من AJAX
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? 0;
$status = $data['status'] ?? '';

if($id && $status){
    $stmt = $pdo->prepare("UPDATE Requests SET Status=? WHERE RequestID=?");
    if($stmt->execute([$status, $id])){
        // If the admin accepted the request, instruct the client to open the welede page
        if($status === 'مقبول'){
            $redirect = 'welede.php?requestID=' . urlencode($id);
            echo json_encode(['success'=>true, 'redirect'=>$redirect]);
        } else {
            echo json_encode(['success'=>true]);
        }
    } else {
        echo json_encode(['success'=>false]);
    }
} else {
    echo json_encode(['success'=>false]);
}
