<?php
$servername = "localhost";
$username = "root";        // DB username
$password = "";            // DB password
$dbname = "crud_system";   // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
