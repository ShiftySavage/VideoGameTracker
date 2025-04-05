<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];
   
    // First, delete associated stats and reviews
    $conn->query("DELETE FROM stats WHERE user_id = '$user_id' AND game_id = '$delete_id'");
    $conn->query("DELETE FROM reviews WHERE user_id = '$user_id' AND game_id = '$delete_id'");

    // Now, delete the game from the user's library
   $delete_game = "DELETE FROM user_games WHERE user_id = '$user_id' AND game_id = '$delete_id'";
   
    if ($conn->query($delete_game) === TRUE) {
        echo "<p class='success'>Game successfully deleted.</p>";
    } else {
        echo "<p class='error'>Error deleting game: " . $conn->error . "</p>";
    }
}

$sql = "SELECT g.id, g.title, g.genre, g.platform, g.release_year
        FROM user_games ug
        INNER JOIN games g ON ug.game_id = g.id
        WHERE ug.user_id = '$user_id'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Games</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Your Games</h2>
        <nav>
            <a href="dashboard.php">Dashboard</a> |
            <a href="add_game.php">Add Game</a> |
            <a href="add_stats.php">Add Stats</a> |
            <a href="add_review.php">Add Review</a> |
            <a href="change_password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </nav>
       
        <!---- Search Bar Below Navigation ----->
        <form method="POST" action="search.php" style="text-align: center; margin-bottom: 20px;">
        <input type="text" name="keyword" placeholder="Search for a game..." required style="padding: 8px; width: 250px; border-radius: 5px; border: 1px solid #00ffff; background-color: #1e1e1e; color: #00ffff;">
        <button type="submit" style="padding: 8px 15px; background-color: #00ffff; color: #121212; border: none; border-radius: 5px; cursor: pointer;">Search</button>
        </form>

        <table border="1">
            <tr>
                <!---<th>Game ID</th>--->
                <th>Title</th>
                <th>Genre</th>
                <th>Platform</th>
                <th>Release Year</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td style='display:none'>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['genre']}</td>
                            <td>{$row['platform']}</td>
                            <td>{$row['release_year']}</td>
                            <td>
                                <a href='view_stats.php?game_id={$row['id']}'>View Stats</a> |
                                <a href='view_reviews.php?game_id={$row['id']}'>View Reviews</a> |
                                <a href='view_game.php?delete_id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this game?\")'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No games found. Make sure you've added games.</td></tr>";
            }
            ?>
            <a href="dashboard.php">Back to Dashboard</a>
        </table>
    </div>
</body>
</html>
