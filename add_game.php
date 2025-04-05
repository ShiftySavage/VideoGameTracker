<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $genre = $_POST["genre"];
    $platform = $_POST["platform"];
    $release_year = $_POST["release_year"];
    $user_id = $_SESSION["user_id"];

    // Insert the game into the games table
    $sql = "INSERT INTO games (title, genre, platform, release_year) VALUES ('$title', '$genre', '$platform', '$release_year')";
   
    if ($conn->query($sql) === TRUE) {
        $game_id = $conn->insert_id;

        // Add the game to the user's library
        $sql = "INSERT INTO user_games (user_id, game_id) VALUES ('$user_id', '$game_id')";
       
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Game added successfully!</p>";
            echo "<a href='view_game.php'>Go to My Games</a>";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add a New Game</h2>
    <form method="POST" action="add_game.php">
        <label>Title:</label><br>
        <input type="text" name="title" required><br>
       
        <label>Genre:</label><br>
        <input type="text" name="genre" required><br>
       
        <label>Platform:</label><br>
        <input type="text" name="platform" required><br>
       
        <label>Release Year:</label><br>
        <input type="number" name="release_year" required><br><br>
       
        <button type="submit">Add Game</button>
    </form>
</body>
</html>