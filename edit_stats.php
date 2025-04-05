<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$stats_id = $_GET["stats_id"];
$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM stats WHERE id = '$stats_id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "No stats found.";
    exit();
}

$stats = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $wins = $_POST["wins"];
    $kd_ratio = $_POST["kd_ratio"];
    $level = $_POST["level"];

    $sql = "UPDATE stats SET wins = '$wins', kd_ratio = '$kd_ratio', level = '$level' WHERE id = '$stats_id'";
   
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Stats updated successfully!</p>";
    } else {
        echo "Error updating stats: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Stats</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Game Stats</h2>
        <form method="POST" action="">
            <label>Wins:</label><br>
            <input type="number" name="wins" value="<?php echo $stats['wins']; ?>" required><br>
           
            <label>K/D Ratio:</label><br>
            <input type="text" name="kd_ratio" value="<?php echo $stats['kd_ratio']; ?>" required><br>
           
            <label>Level:</label><br>
            <input type="number" name="level" value="<?php echo $stats['level']; ?>" required><br><br>
           
            <button type="submit">Update Stats</button>
        </form>
        <br>
        <a href="view_stats.php?game_id=<?php echo $stats['game_id']; ?>">Back to Stats</a>
    </div>
</body>
</html>
