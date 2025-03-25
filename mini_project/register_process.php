<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password with bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $check_email_sql = "SELECT * FROM users_mulyani WHERE email = '$email'";
    $check_email_result = $conn->query($check_email_sql);

    if ($check_email_result->num_rows > 0) {
        header("Location: register.php?error=Email already exists. Please use a different email address.");
        exit();
    }

    // If email is unique, proceed with registration
    $sql = "INSERT INTO users_mulyani (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        // Pass username as a parameter to login.php
        header("Location: login.php?success=Registration successful." );
        exit();
    } else {
        header("Location: register.php?error=Registration failed. Please try again.");
        exit();
    }
}

$conn->close();
?>
