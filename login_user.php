<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
session_start();

$message = "";

if (isset($_POST['submit'])) {

    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname  = $conn->real_escape_string($_POST['lastname']);
    $email     = $conn->real_escape_string($_POST['email']);
    $password  = $_POST['password'];

    // CHECK IF USER EXISTS
    $sql_check = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // USER EXISTS → LOGIN
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            // LOGIN SUCCESS
           $_SESSION['username']  = $row['firstname'] . ' ' . $row['lastname'];
$_SESSION['email']     = $row['email'];
$_SESSION['role']      = $row['role'];


            header("Location: dashboard_user.php");
            exit;

        } else {
            $message = "<h2 style='color:red;'>Wrong password. Try again.</h2>";
        }

    } else {
        // REGISTER NEW USER WITH DEFAULT ROLE 'user'
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_insert = "INSERT INTO users (firstname, lastname, email, password, role)
                       VALUES ('$firstname', '$lastname', '$email', '$hashed_password', 'user')";

        if ($conn->query($sql_insert)) {

            $_SESSION['firstname'] = $firstname;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "user";

            header("Location: dashboard_user.php");
            exit;

        } else {
            $message = "<h2 style='color:red;'>Error: " . $conn->error . "</h2>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Login page</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container text-center mt-5">

    <h1 class="text-primary">Dear our coustemer login first to access our library system</h1>

    <?php if($message != "") echo $message; ?>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card p-4">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success">Login / Register</button>
                </form>
            </div>
        </div>
    </div>

</div>

</body>
</html>
