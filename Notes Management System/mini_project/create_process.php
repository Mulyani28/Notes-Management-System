<?php

include 'db.php';

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];

    $sql = "INSERT INTO notes(title, content, date) VALUES ('$title', '$content','$date')";

    if ($conn->query($sql)===TRUE)
    {
        header ("Location: dashboard.php");//Redirect to the main page after successfull insertion
    }

    else{
        echo "Error: " . $sl . "<br>". $conn->error;
    }
}

$conn->close();

?>