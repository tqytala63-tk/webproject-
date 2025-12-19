<?php
require 'config.php';

$counts = [];

// نفس الدالة المستخدمة في dashboard
function getCounts($pdo){
    $total = $pdo->query("SELECT COUNT(*) FROM Requests")->fetchColumn();
    $processing = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='قيد المعالجة'")->fetchColumn();
    $approved = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='مقبول'")->fetchColumn();
    $rejected = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='مرفوض'")->fetchColumn();
    $completed = $pdo->query("SELECT COUNT(*) FROM Requests WHERE Status='منجز'")->fetchColumn();

    $types = [
        'إخراج قيد فردي',
        'إخراج قيد عائلي',
        'بطاقة الهوية',
        'وثيقة ولادة',
        'وثيقة وفاة',
        'وثيقة زواج'
    ];

    $typeCounts = [];
    foreach ($types as $type) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Requests WHERE TransactionType = ?");
        $stmt->execute([$type]);
        $typeCounts[$type] = $stmt->fetchColumn();
    }

    return [
        'total'=>$total,
        'processing'=>$processing,
        'approved'=>$approved,
        'rejected'=>$rejected,
        'completed'=>$completed,
        'types'=>$typeCounts
    ];
}

header('Content-Type: application/json');
echo json_encode(getCounts($pdo));
