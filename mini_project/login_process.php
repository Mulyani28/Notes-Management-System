<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password (additional validation may be added)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Sanitize input to prevent SQL injection
        $email = mysqli_real_escape_string($conn, $email);

        // Fetch user from the database by email
        $sql = "SELECT * FROM users_mulyani WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables and redirect
                $_SESSION['users_id'] = $row['users_id'];
                $_SESSION['email'] = $row['email'];

                // Set the username in the session (replace $username with the actual field name from your users table)
                $_SESSION['username'] = $row['username'];

                header("Location: dashboard.php"); // Redirect to dashboard or desired page
                exit();
            } else {
                header("Location: login.php?error=Incorrect password");
                exit();
            }
        } else {
            header("Location: login.php?error=User not found");
            exit();
        }
    } else {
        header("Location: login.php?error=Invalid email format");
        exit();
    }
}

$conn->close();
?>
