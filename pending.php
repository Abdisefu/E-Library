<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>

<!doctype html>
<html>
<head>
<title>Account Pending</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow text-center">
    <h3 class="text-warning">Account Pending ⏳</h3>
    <p>Your account has been blocked by the administrator.</p>
    <p>Please wait or contact admin. call to +1251-922396432</p>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</div>

</body>
</html>
