<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

function logActivity($fileName) {

    if (!isset($_SESSION['username'])) return;

    global $conn;

    $username = $_SESSION['username'];
    $email    = $_SESSION['email'] ?? '';

    $stmt = $conn->prepare(
        "INSERT INTO file_access_log (username, email, file_name)
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $username, $email, $fileName);
    $stmt->execute();
}
