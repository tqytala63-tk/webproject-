<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$for = $_GET['for'] ?? 'me';

if ($for == 'child') {
    // إنشاء UserID جديد للطفل
    $stmt = $pdo->prepare("INSERT INTO users (Role, ParentID) VALUES (?, ?)");
    $stmt->execute(['Child', $_SESSION['user_id']]);
    $childID = $pdo->lastInsertId();

    // تحويل للفورم مع UserID الطفل
    header("Location: birth_form.php?for=child&child_id=$childID");
    exit;
} else {
    // إذا إلي المستخدم نفسه
    header("Location: birth_form.php?for=me");
    exit;
}
