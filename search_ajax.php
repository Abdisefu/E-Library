<?php
include 'db.php';

if (!isset($_GET['keyword'])) exit;

$keyword = trim($_GET['keyword']);
if ($keyword === "") {
    echo '<div class="list-group-item">Type something to search...</div>';
    exit;
}

$like = "%" . $keyword . "%";

$sql = "SELECT id, title, author, isbn, published_year
        FROM books
        WHERE title LIKE ?
           OR author LIKE ?
           OR isbn LIKE ?
        LIMIT 20";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $title = htmlspecialchars($row['title']);
        $author = htmlspecialchars($row['author']);
        $isbn = htmlspecialchars($row['isbn']);

        $pattern = "/" . preg_quote($keyword, '/') . "/i";
        $title = preg_replace($pattern, "<mark>$0</mark>", $title);
        $author = preg_replace($pattern, "<mark>$0</mark>", $author);
        $isbn = preg_replace($pattern, "<mark>$0</mark>", $isbn);

        echo '<a href="view.php?id=' . $row['id'] . '" class="list-group-item list-group-item-action">'
            . $title . ' | ' . $author . ' | ' . $isbn . ' (' . $row['published_year'] . ')'
            . '</a>';
    }
} else {
    echo '<div class="list-group-item">No results found</div>';
}

$stmt->close();
$conn->close();
?>
