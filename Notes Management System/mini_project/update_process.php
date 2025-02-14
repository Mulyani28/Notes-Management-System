<?php
    include 'db.php';

    if($_SERVER["REQUEST_METHOD"]== "POST")
    {
        $id = $_POST['notesId'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];

        $sql = "UPDATE notes SET title = '$title', content='$content', date='$date' WHERE notesId = $id";
        if ($conn->query($sql) === TRUE)
        {
            header("Location: dashboard.php");
        }
        else{
            echo"Error updating notes: ".$conn->error;
        }
    }

?>