<?php
    include 'db.php';

    if(isset($_GET['notesId']))
    {
        $id = $_GET['notesId'];
        $sql = "DELETE FROM notes WHERE notesId=$id";

        if($conn->query($sql)=== TRUE)
        {
            header("Location: notelist.php");
        }
        else{
            echo "Error deleting client: ". $conn->error;
        }
    }
    else{
        echo "Invalid request.";
    }

    $conn->close();

?>