<?php
    include 'db.php';

    if($_SERVER["REQUEST_METHOD"]== "POST")
    {
        $id = $_POST['notesId'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];
        $priority = $_POST['priority'];
        $category = $_POST['category'];
        $reminder_date = $_POST['reminder_date'];
        $recurrence = $_POST['recurrence'];


        $sql = "UPDATE notes SET title = '$title', content='$content', date='$date', priority = '$priority', category = '$category',reminder_date = '$reminder_date', recurrence='$recurrence' WHERE notesId = $id";
        if ($conn->query($sql) === TRUE)
        {
            header("Location: dashboard.php");
        }
        else{
            echo"Error updating notes: ".$conn->error;
        }
    }

?>