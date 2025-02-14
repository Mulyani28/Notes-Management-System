<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Escape user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query the database to get the hashed password
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the entered password against the stored hash
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php"); // Redirect to the dashboard or any other authenticated page
        } else {
            echo "Wrong Password.";
        }
    } else {
        echo "Invalid login credentials.";
    }

    $conn->close();
}
?>