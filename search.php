<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$searchResults = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $keyword = $conn->real_escape_string($_POST["keyword"]);

    $sql = "SELECT * FROM games WHERE title LIKE '%$keyword%'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $searchResults = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Games</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Search Games</h2>

    <form method="POST" action="search.php">
        <label for="keyword">Enter Game Title:</label>
        <input type="text" name="keyword" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <h3>Search Results:</h3>
        <?php if (count($searchResults) > 0): ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Platform</th>
                    <th>Release Year</th>
                </tr>
                <?php foreach ($searchResults as $game): ?>
                    <tr>
                        <td><?= htmlspecialchars($game['title']) ?></td>
                        <td><?= htmlspecialchars($game['genre']) ?></td>
                        <td><?= htmlspecialchars($game['platform']) ?></td>
                        <td><?= htmlspecialchars($game['release_year']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No games found matching your search.</p>
        <?php endif; ?>
    <?php endif; ?>

    <a class="back-link" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>