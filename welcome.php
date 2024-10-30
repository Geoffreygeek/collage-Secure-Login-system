<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e0f7fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { text-align: center; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); }
        h2 { color: #007bb5; }
        .logout { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #007bb5; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; }
        .logout:hover { background-color: #005f8f; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?= $_SESSION['name'] ?>!</h2>
        <p>You have successfully registered and logged in
            welcome to admin page.</p>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
