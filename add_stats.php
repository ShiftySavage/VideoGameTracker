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
    $wins = $_POST["wins"];
    $kd_ratio = $_POST["kd_ratio"];
    $level = $_POST["level"];

    $sql = "INSERT INTO stats (user_id, game_id, wins, kd_ratio, level)
            VALUES ('$user_id', '$game_id', '$wins', '$kd_ratio', '$level')";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>Stats added successfully!</p>";
    echo "<a href='view_game.php'>Go to My Games</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Stats</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add Stats for a Game</h2>
    <form method="POST" action="add_stats.php">
        <label>Game ID:</label><br>
        <input type="number" name="game_id" required><br>
       
        <label>Wins:</label><br>
        <input type="number" name="wins" required><br>
       
        <label>K/D Ratio:</label><br>
        <input type="text" name="kd_ratio" required><br>
       
        <label>Level:</label><br>
        <input type="number" name="level" required><br><br>
       
        <button type="submit">Add Stats</button>
    </form>
</body>
</html>