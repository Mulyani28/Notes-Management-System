
<?php
// Include database connection and session start
include 'db.php';
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['users_id'])) {
    // Redirect or handle the case where the user is not authenticated
    header("Location: login.php");
    exit();
}

// Assuming form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process task creation form data

    // Insert into notes table
    $noteTitle = $_POST['note_title'];
    $noteContent = $_POST['note_content'];

    $sqlNote = "INSERT INTO notes (title, content, users_id) VALUES ('$noteTitle', '$noteContent', '{$_SESSION['users_id']}')";
    $resultNote = $conn->query($sqlNote);

    if ($resultNote) {
        // Note created successfully, retrieve note ID
        $noteId = $conn->insert_id;

        // Assuming you have user IDs available
        $assignedToUserId = $_POST['assigned_to']; // Replace with actual form field

        // Insert into note_assignments table
        $sqlAssignment = "INSERT INTO note_assignments (notesId, assigned_to, assigned_by) VALUES ('$noteId', '$assignedToUserId', '{$_SESSION['users_id']}')";
        $resultAssignment = $conn->query($sqlAssignment);

        if ($resultAssignment) {
            echo "Note and assignment created successfully!";
        } else {
            echo "Error creating assignment: " . $conn->error;
        }
    } else {
        echo "Error creating note: " . $conn->error;
    }
}

$conn->close();
?>
