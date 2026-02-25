<?php
include 'db.php';

// Get the book ID from GET
if (!isset($_GET['id']) || trim($_GET['id']) === '') {
    die("No book selected.");
}

$id = (int)$_GET['id']; // sanitize input

$query = "SELECT * FROM books WHERE id = $id LIMIT 1";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    die("Book not found.");
}

$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($row['title']); ?> - Book Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="card">
    <div class="card-body">
        <h3 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h3>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn']); ?></p>
        <p><strong>Published:</strong> <?php echo htmlspecialchars($row['published_year']); ?></p>
        <p><strong>Available:</strong> <?php echo ($row['available'] ? 'Yes' : 'No'); ?></p>
        <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="btn btn-primary" target="_blank">Open File</a>
    </div>
</div>

</body>
</html>
