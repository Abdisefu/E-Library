<?php
$password = 'sen4absen4ab'; // choose your password
$hashed = password_hash($password, PASSWORD_DEFAULT);
echo $hashed;
?>
