<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div style="text-align: center; margin-top: 20px;">
        <img src="images/logo.png" alt="Game Tracker Logo" style="width: 300px;">
    </div>

    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        
        <div class="nav-container">
        <nav>
            <a href="add_game.php">Add Game</a> |
            <a href="view_game.php">View Your Games</a> |
            <a href="add_stats.php">Add Stats</a> |
            <a href="add_review.php">Add Review</a> |
            <a href="logout.php">Logout</a>
            <a href="change_password.php">Change Password</a>
        </nav>
        </div>

        <!---- Search Bar Below Navigation ----->
        <form method="POST" action="search.php" style="text-align: center; margin-bottom: 20px;">
        <input type="text" name="keyword" placeholder="Search for a game..." required style="padding: 8px; width: 250px; border-radius: 5px; border: 1px solid #00ffff; background-color: #1e1e1e; color: #00ffff;">
        <button type="submit" style="padding: 8px 15px; background-color: #00ffff; color: #121212; border: none; border-radius: 5px; cursor: pointer;">Search</button>
        </form>

       
        <h3>What would you like to do today?</h3>
        <ul>
            <li><a href="add_game.php">Add a New Game</a></li>
            <li><a href="view_game.php">Manage Your Games (View, Delete, Stats, Reviews)</a></li>
            <li><a href="add_stats.php">Update Game Stats</a></li>
            <li><a href="add_review.php">Submit a Game Review</a></li>
        </ul>
    </div>
</body>
</html>