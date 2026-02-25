<?php
require 'log_activity.php';
logActivity('Read');

include 'db.php'; // Connect to database
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Read Books</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Include Navbar -->
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Include the correct navbar based on role
if ($_SESSION['role'] === 'admin') {
    include 'navbar.php';   // admin navbar
} elseif ($_SESSION['role'] === 'user') {
    include 'navbar2.php';  // user navbar
} else {
    // Optional: unknown role, redirect to login
    header("Location: login.php");
    exit;
}
?>


<div class="container mt-5 bg-info">
    <h2>All Books</h2>

    <?php
    // Fetch all books from the database
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Published Year</th>
                <th>Available</th>
                <th>File</th>
              </tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td>' . htmlspecialchars($row['author']) . '</td>';
            echo '<td>' . htmlspecialchars($row['isbn']) . '</td>';
            echo '<td>' . htmlspecialchars($row['published_year']) . '</td>';
            echo '<td>' . ($row['available'] ? 'Yes' : 'No') . '</td>';

            // File link
            if (!empty($row['file_path'])) {
                echo '<td><a href="' . htmlspecialchars($row['file_path']) . '" target="_blank">Download</a></td>';
            } else {
                echo '<td>Not uploaded</td>';
            }

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="text-warning">No books found.</p>';
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
