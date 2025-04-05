<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$game_id = $_GET["game_id"];

$sql = "SELECT * FROM stats WHERE user_id = '$user_id' AND game_id = '$game_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Stats</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Game Stats</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>Wins:</strong> {$row['wins']}</p>";
                echo "<p><strong>K/D Ratio:</strong> {$row['kd_ratio']}</p>";
                echo "<p><strong>Level:</strong> {$row['level']}</p>";
                echo "<a href='edit_stats.php?stats_id={$row['id']}'>Edit Stats</a>";
            }
        } else {
            echo "<p>No stats found for this game.</p>";
        }
        ?>
        <br>
        <a href="view_game.php">Back to Games</a>
    </div>
</body>
</html>
