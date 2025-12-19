<?php

function isLoggedIn() {
    if (!isset($_SESSION["user"])) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit;
    }
}

function authorizeRoles($roles) {
    $userRole = $_SESSION["user"]["role"] ?? null;

    if (!in_array($userRole, $roles)) {
        http_response_code(403);
        echo json_encode(["error" => "Forbidden"]);
        exit;
    }
}

?>
