<?php

session_start();
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    //hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_result = $conn->query($check_sql);

    if($check_result->num_rows>0)
    {
        echo "Username already existx. Please choose a different username.";
    }
    else{
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        if($conn->query($sql)=== TRUE)
        {
            header("Location: login.php");
            //echo "Registration successfull. You can now login.";

        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

    $conn->close();
?>