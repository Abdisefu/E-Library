<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
session_start();

$message = "";

if (isset($_POST['submit'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // CHECK ADMIN ONLY
    $sql = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // VERIFY PASSWORD
        if (password_verify($password, $row['password'])) {
            // LOGIN SUCCESSFUL
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard_admin.php");
            exit;
        } else {
            $message = "<h2 style='color:red;text-align:center;'>Incorrect Password!</h2>";
        }
    } else {
        $message = "<h2 style='color:red;text-align:center;'>You are not Admin! please login to the system by user account if you are not an Admin</h2>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>E-Library Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container overflow-hidden text-center">
    <div class="text-primary">
        <h1>Login page for Admin</h1>
    </div>

    <?php if ($message != "") echo $message; ?>

    <div class="row">
        <div class="col-md-6 p-5">
            <div class="card" style="width: 35rem">
                <img src="login.jpg" class="card-img-top" alt="Login Image">
            </div>
        </div>

        <div class="col-md-6 p-5">
            <div class="card">
                <div class="card-body">

                    <form action="" method="POST">

                        <div class="row py-3">
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required placeholder="name@example.com">
                            </div>
                        </div>

                        <div class="row py-3">
                            <div class="col-12">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required placeholder="***********">
                            </div>
                        </div>

                        <div class="row py-3">
                            <div class="col-12">
                                <button type="submit" name="submit" class="btn btn-primary mx-2">Login</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
