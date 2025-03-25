<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $users_id = $_SESSION['users_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $priority = $_POST['priority'];
    $category = $_POST['category'];
    
    // Check if 'reminder_date' is set before accessing it
    $reminder_date = isset($_POST['reminder_date']) ? $_POST['reminder_date'] : '';
    $recurrence = $_POST['recurrence'];

    // Validate and sanitize user inputs
    $users_id = mysqli_real_escape_string($conn, $users_id);
    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $date = mysqli_real_escape_string($conn, $date);
    $priority = mysqli_real_escape_string($conn, $priority);
    $category = mysqli_real_escape_string($conn, $category);
    $reminder_date = mysqli_real_escape_string($conn, $reminder_date);
    $recurrence = mysqli_real_escape_string($conn, $recurrence);

    // Check for empty fields
    if (empty($users_id) || empty($title) || empty($content) || empty($date) || empty($priority) || empty($category) || empty($reminder_date) || empty($recurrence)) {
        echo "Error: All fields are required.";
        exit(); // or handle the error appropriately
    }

    // Check if users_id exists in the users table
    $check_user_query = "SELECT users_id FROM users_mulyani WHERE users_id = ?";
    $stmtCheckUser = $conn->prepare($check_user_query);
    $stmtCheckUser->bind_param("i", $users_id);
    $stmtCheckUser->execute();
    $stmtCheckUser->store_result();

    if ($stmtCheckUser->num_rows == 0) {
        echo "Error: Invalid users_id.";
        exit(); // or handle the error appropriately
    }

    // Use prepared statement to insert data into the notes table
    $stmtInsertNote = $conn->prepare("INSERT INTO notes (title, content, priority, date, users_id, category, reminder_date, recurrence) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtInsertNote->bind_param("ssssssss", $title, $content, $priority, $date, $users_id, $category, $reminder_date, $recurrence);

    if ($stmtInsertNote->execute()) {
        // Get the last inserted note_id
        $notesId = $stmtInsertNote->insert_id;

        // Retrieve user input for assigned_to
        $assigned_to = $_POST['assigned_to'];

        // Check if assigned_to is not empty
        if (!empty($assigned_to) && is_array($assigned_to)) {
            // Insert assignment into note_assignment table
            $stmtInsertAssignment = $conn->prepare("INSERT INTO note_assignments (notesId, assigned_to, assigned_by) VALUES (?, ?, ?)");

            foreach ($assigned_to as $assignedTo) {
                $stmtInsertAssignment->bind_param("iis", $notesId, $assignedTo, $users_id);
                $stmtInsertAssignment->execute();
            }

            $stmtInsertAssignment->close();
        }

        header("Location: dashboard.php"); // Redirect to the main page after successful insertion
    } else {
        echo "Error: " . $stmtInsertNote->error;
    }

    $stmtInsertNote->close();
    $stmtCheckUser->close();
}

$conn->close();
?>
