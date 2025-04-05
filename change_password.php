<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];

    // Complexity Check
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";
    if (!preg_match($pattern, $new_password)) {
        $error = "New password must meet complexity requirements.";
    } else {
        // Get current password hash
        $sql = "SELECT password FROM users WHERE id = '$user_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if (!password_verify($current_password, $row["password"])) {
            $error = "Current password is incorrect.";
        } else {
            $hashedNew = password_hash($new_password, PASSWORD_DEFAULT);
            $update = "UPDATE users SET password = '$hashedNew' WHERE id = '$user_id'";

            if ($conn->query($update) === TRUE) {
                $success = "Password changed successfully!";
            } else {
                $error = "Error updating password: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Change Password</h2>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>
    <form method="POST" action="change_password.php">
        <label>Current Password:</label>
        <input type="password" name="current_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>
        <small>Password must be at least 8 characters and include uppercase, lowercase, number, and special character.</small><br>

        <button type="submit">Update Password</button>
    </form>
    <a class="back-link" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
