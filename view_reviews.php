<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$game_id = $_GET["game_id"];

$sql = "SELECT r.review_text, r.rating, u.username
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        WHERE r.game_id = '$game_id'";
       
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Reviews</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Game Reviews</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div><strong>{$row['username']}</strong> rated this game: {$row['rating']}/10</div>";
                echo "<div>{$row['review_text']}</div><hr>";
            }
        } else {
            echo "<p>No reviews found for this game.</p>";
        }
        ?>
        <a href="view_game.php">Back to Games</a>
    </div>
</body>
</html>