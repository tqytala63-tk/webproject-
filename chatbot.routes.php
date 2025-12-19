<?php
require_once "chatbot.controller.php";
require_once "auth_middleware.php";

// ------------ USER CHAT --------------
if ($_SERVER["REQUEST_URI"] === "/api/chat" && $_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    isLoggedIn();
    authorizeRoles(["user"]);
    chatWithGemini();
}

// ------------ ADMIN CHAT --------------
if ($_SERVER["REQUEST_URI"] === "/api/chatDash" && $_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    isLoggedIn();
    authorizeRoles(["admin","adminShop"]);
    chatWithGeminiDash();
}

// ------------ SUGGESTIONS --------------
if ($_SERVER["REQUEST_URI"] === "/api/suggestions" && $_SERVER["REQUEST_METHOD"] === "GET") {
    session_start();
    isLoggedIn();
    authorizeRoles(["user"]);
    getChatSuggestions();
}
?>
