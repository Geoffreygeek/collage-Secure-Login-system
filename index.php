<?php
session_start();
include 'database-connect.php';

$message = "";

// Handle Registration
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, phone, email, position, password) VALUES ('$name', '$phone', '$email', '$position', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful! Please log in.";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Handle Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            header("Location: welcome.php");
            exit();
        } else {
            $message = "Invalid credentials!";
        }
    } else {
        $message = "Invalid credentials!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e0f7fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { max-width: 400px; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); }
        h2 { color: #007bb5; text-align: center; }
        form { display: flex; flex-direction: column; }
        input[type="text"], input[type="email"], input[type="password"], input[type="submit"] { padding: 10px; margin: 8px 0; border: 1px solid #007bb5; border-radius: 4px; }
        input[type="submit"] { background-color: #007bb5; color: white; font-weight: bold; cursor: pointer; }
        input[type="submit"]:hover { background-color: #005f8f; }
        .message { color: red; text-align: center; }
        .switch { text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <div class="message"><?= $message ?></div>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="position" placeholder="Position" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" name="register" value="Register">
        </form>

        <h2>Login</h2>
        <form action="" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>
</html>
