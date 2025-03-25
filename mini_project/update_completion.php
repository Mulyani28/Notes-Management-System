<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $notesId = $_POST['notesId'];
    $status = $_POST['status'];

    // Update completion status in the database
    $sql = "UPDATE notes SET completion_status = '$status' WHERE notesId = $notesId";
    if ($conn->query($sql) === TRUE) {
        echo "Completion status updated successfully";
    } else {
        echo "Error updating completion status: " . $conn->error;
    }
}

$conn->close();
?>
