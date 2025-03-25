<?php
// assigned_notes.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check if the users_id is set in the session
if (!isset($_SESSION['users_id'])) {
    // Redirect or handle the case where the user is not authenticated
    header("Location: login.php");
    exit();
}

$users_id = $_SESSION['users_id'];

// Fetch notes owned by the user along with details
$sql = "SELECT n.*, u_assigned.username AS assigned_to, 
               CASE 
                 WHEN na.status IS NOT NULL THEN na.status
                 ELSE n.completion_status -- Use the owner's status if note is not assigned or note_assignments status is not set
               END AS status
        FROM notes n
        LEFT JOIN note_assignments na ON n.notesId = na.notesId
        LEFT JOIN users_mulyani u_assigned ON na.assigned_to = u_assigned.users_id
        WHERE n.users_id = '$users_id'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $rowNumber = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowNumber . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["content"] . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>" . ($row["assigned_to"] ? $row["assigned_to"] : "Not Assigned") . "</td>";
        
        // Display the status
        echo "<td>" . $row["status"] . "</td>";
        
        echo "</tr>";
        $rowNumber++;
    }
} else {
    echo "No notes found for you.";
}

$conn->close();
?>
