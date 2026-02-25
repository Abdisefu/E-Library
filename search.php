<?php
include 'db.php';
require 'log_activity.php';

session_start();

// Check login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Log search activity
if (!empty($_GET['keyword'])) {
    logActivity('Search: ' . $_GET['keyword']);
}

// Get keyword
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books - E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background:#f8f9fa; padding-bottom:30px; }
        mark { background: yellow; }
    </style>
</head>
<body>

<?php
// Role-based navbar
if ($_SESSION['role'] === 'admin') {
    include 'navbar.php';
} elseif ($_SESSION['role'] === 'user') {
    include 'navbar2.php';
} else {
    header("Location: login.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Search Books</h2>

    <!-- SEARCH FORM -->
    <form method="GET" class="d-flex mb-3" style="gap:10px;">
        <input
            type="text"
            name="keyword"
            id="keyword"
            class="form-control"
            placeholder="Type keyword..."
            autocomplete="off"
            value="<?php echo htmlspecialchars($keyword); ?>"
        >
        <button class="btn btn-primary">Search</button>
    </form>

    <!-- LIVE RESULTS -->
    <div id="searchResults" class="list-group mb-3"></div>

<?php
// NORMAL SEARCH RESULT
if ($keyword !== '') {

    $like = "%" . $keyword . "%";

    $stmt = $conn->prepare(
        "SELECT * FROM books
         WHERE title LIKE ?
            OR author LIKE ?
            OR isbn LIKE ?"
    );

    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<p>No results found for <mark>" . htmlspecialchars($keyword) . "</mark></p>";
    } else {
        echo "<h4>Results for: <mark>" . htmlspecialchars($keyword) . "</mark></h4><hr>";

        while ($row = $result->fetch_assoc()) {

            $title = htmlspecialchars($row['title']);
            $author = htmlspecialchars($row['author']);
            $isbn = htmlspecialchars($row['isbn']);

            $pattern = "/" . preg_quote($keyword, '/') . "/i";
            $title = preg_replace($pattern, "<mark>$0</mark>", $title);
            $author = preg_replace($pattern, "<mark>$0</mark>", $author);
            $isbn = preg_replace($pattern, "<mark>$0</mark>", $isbn);

            echo '
            <div class="border p-3 mb-3 bg-white rounded">
                <h5>
                    <a href="view.php?id=' . $row['id'] . '">' . $title . '</a>
                </h5>
                <p><strong>Author:</strong> ' . $author . '</p>
                <p><strong>ISBN:</strong> ' . $isbn . '</p>
                <p><strong>Published:</strong> ' . htmlspecialchars($row['published_year']) . '</p>
                <p><strong>Available:</strong> ' . ($row['available'] ? 'Yes' : 'No') . '</p>
            </div>';
        }
    }

    $stmt->close();
}
$conn->close();
?>
</div>

<script>
// LIVE SEARCH
document.getElementById("keyword").addEventListener("keyup", function () {
    let keyword = this.value;

    if (keyword.length < 1) {
        document.getElementById("searchResults").innerHTML = "";
        return;
    }

    fetch("search_ajax.php?keyword=" + encodeURIComponent(keyword))
        .then(res => res.text())
        .then(data => {
            document.getElementById("searchResults").innerHTML = data;
        });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
