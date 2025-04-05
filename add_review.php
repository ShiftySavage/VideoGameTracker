<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $game_id = $_POST["game_id"];
    $rating = $_POST["rating"];
    $review_text = $_POST["review_text"];

    $sql = "INSERT INTO reviews (user_id, game_id, rating, review_text)
            VALUES ('$user_id', '$game_id', '$rating', '$review_text')";

    if ($conn->query($sql) === TRUE) {
        echo "Review added successfully!";
        echo "<a href='view_game.php'>Go to My Games</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add a Review</h2>
        <form method="POST" action="add_review.php">
            <label>Game ID:</label>
            <input type="number" name="game_id" required>

            <label>Rating (1-10):</label>
            <input type="number" name="rating" min="1" max="10" required>

            <label>Review:</label>
            <textarea name="review_text" rows="5" required></textarea>

            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>
</html>