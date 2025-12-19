<?php
session_start();
require 'config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){ exit; }

$requestID = $_POST['requestID'];
$newStatus = $_POST['newStatus'];

// جلب الحالة القديمة
$oldStatus = $pdo->query("SELECT Status FROM Requests WHERE RequestID=$requestID")->fetchColumn();

// تحديث الحالة
$stmt = $pdo->prepare("UPDATE Requests SET Status=? WHERE RequestID=?");
$stmt->execute([$newStatus, $requestID]);

// حفظ التغيير في RequestStatusHistory
$stmt = $pdo->prepare("INSERT INTO RequestStatusHistory (RequestID, OldStatus, NewStatus, ChangedBy) VALUES (?,?,?,?)");
$stmt->execute([$requestID, $oldStatus, $newStatus, $_SESSION['FullName']]);
?>
