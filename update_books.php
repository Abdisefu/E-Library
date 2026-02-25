<?php
include 'db.php'; // Database connection

$message = "";

// Ensure a book ID is provided
if (!isset($_GET['id'])) {
    die("Book ID is missing.");
}

$id = intval($_GET['id']);

// Fetch existing book data
$get_book = "SELECT * FROM books WHERE id = $id";
$result = $conn->query($get_book);

if ($result->num_rows != 1) {
    die("Book not found.");
}

$book = $result->fetch_assoc();

// Handle form submission
if (isset($_POST['update_book'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $published_year = $conn->real_escape_string($_POST['published_year']);
    $available = isset($_POST['available']) ? 1 : 0;

    $update_sql = "
        UPDATE books SET
            title='$title',
            author='$author',
            isbn='$isbn',
            published_year='$published_year',
            available='$available'
        WHERE id=$id
    ";

    if ($conn->query($update_sql) === TRUE) {
        $message = "<p class='text-success'>Book updated successfully!</p>";

        // Reload updated data
        $result = $conn->query($get_book);
        $book = $result->fetch_assoc();
    } else {
        $message = "<p class='text-danger'>Error updating: " . $conn->error . "</p>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Book</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Update Book</h2>
    <?php if ($message != "") echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" class="form-control" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ISBN</label>
            <input type="text" class="form-control" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Published Year</label>
            <input type="number" class="form-control" name="published_year" value="<?php echo htmlspecialchars($book['published_year']); ?>">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="available" <?php echo $book['available'] ? 'checked' : ''; ?>>
            <label class="form-check-label">Available</label>
        </div>

        <button type="submit" name="update_book" class="btn btn-primary">Update Book</button>
    </form>
</div>

</body>
</html>
