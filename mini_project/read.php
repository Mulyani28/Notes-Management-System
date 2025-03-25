<?php
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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteConfirmation'])) {
    $idToDelete = $_POST['deleteConfirmation'];

    // Perform the deletion here based on $idToDelete
    $sqlDelete = "DELETE FROM notes WHERE notesId = '$idToDelete'";
    if ($conn->query($sqlDelete) === TRUE) {
        // Handle successful deletion, if needed
    } else {
        // Handle deletion error, if needed
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateCompletionStatus'])) {
    $idToUpdate = $_POST['updateCompletionStatus'];
    $newStatus = $_POST['completionStatus'];
    $users_id = $_SESSION['users_id'];

    $sqlCheckOwner = "SELECT * FROM notes WHERE notesId = '$idToUpdate' AND users_id = '$users_id'";
    $resultCheckOwner = $conn->query($sqlCheckOwner);


    // Perform the update here based on $idToUpdate and $newStatus
    if ($resultCheckOwner->num_rows > 0) {
        // User is the owner, update in notes table
        $sqlUpdate = "UPDATE notes SET completion_status = '$newStatus' WHERE notesId = '$idToUpdate'";
    } else {
        // User is not the owner, update in note_assignments table
        $sqlUpdate = "UPDATE note_assignments SET status = '$newStatus' WHERE notesId = '$idToUpdate' AND assigned_to = '$users_id'";
    }
    if ($conn->query($sqlUpdate) === TRUE) {
        // Handle successful update, if needed
    } else {
        // Handle update error, if needed
    }
}
$users_id = $_SESSION['users_id'];

$sql = "(
    SELECT n.*, NULL AS assigned_to, NULL AS assigned_by, NULL AS assigned_user_status
    FROM notes n 
    WHERE n.users_id = '$users_id'
) 
UNION 
(
    SELECT n.*, u_assigned.username AS assigned_to, 
    CASE 
        WHEN n.users_id = '$users_id' THEN 'Own Notes'
        WHEN na.assigned_by = '$users_id' THEN 'Owner Notes'
        ELSE u_assigned_by.username 
    END AS assigned_by,
    na.status AS assigned_user_status
    FROM notes n
    JOIN note_assignments na ON n.notesId = na.notesId
    LEFT JOIN users_mulyani u_assigned ON na.assigned_to = u_assigned.users_id
    LEFT JOIN users_mulyani u_assigned_by ON na.assigned_by = u_assigned_by.users_id
    WHERE na.assigned_to = '$users_id'
)";
$result = $conn->query($sql);
$rowNumber = 1;

if ($result->num_rows > 0) {
    $prevNotesId = null; // Initialize variable to track previous notesId

    while ($row = $result->fetch_assoc()) {
        // Check if notesId has changed
        if ($row["notesId"] !== $prevNotesId) {
            // Display notesId, title, content, date, and details button
            echo "<tr>";
            echo "<td>" . $rowNumber . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["content"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>
                    <button type='button' class='btn btn-info' data-toggle='modal' data-target='#detailsModal" . $row["notesId"] . "' title='Details'>&#8505;</button>
                    
                    <!-- Modal to show details -->
                    <div class='modal fade' id='detailsModal" . $row["notesId"] . "' tabindex='-1' role='dialog' aria-labelledby='detailsModalLabel' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='detailsModalLabel'>Note Details</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <p><strong>Title:</strong> " . $row["title"] . "</p>
                                    <p><strong>Description:</strong> " . $row["content"] . "</p>
                                    <p><strong>Due Date:</strong> " . $row["date"] . "</p>
                                    <p><strong>Priority:</strong> " . $row["priority"] . "</p>
                                    <p><strong>Category:</strong> " . $row["category"] . "</p>
                                    <p><strong>Reminder Date:</strong> " . $row["reminder_date"] . "</p>
                                    <p><strong>Completion Status:</strong> " . $row["completion_status"] . "</p>
                                    <p><strong>Assigned By:</strong> ";

                                    if ($row["assigned_by"] == 'Owner Notes') {
                                        echo 'Owner Notes';
                                    } elseif ($row["users_id"] == $users_id) {
                                        echo 'Own Notes';
                                    } else {
                                        echo htmlspecialchars($row["assigned_by"]);
                                    }
                                    "</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>";
        

        // Display Edit, Delete, and Update Status buttons
        echo "<td>
            <a href='update_form.php?notesId=" . $row["notesId"] . "' class='btn btn-warning' title='Edit'>&#9998;</a>
            
            <!-- Button trigger modal -->
            <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#confirmDeleteModal" . $row["notesId"] . "' title='Delete'>&#128465;</button>
            
            <!-- Modal -->
            <div class='modal fade' id='confirmDeleteModal" . $row["notesId"] . "' tabindex='-1' role='dialog' aria-labelledby='confirmDeleteModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='confirmDeleteModalLabel'>Confirm Delete</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            Are you sure you want to delete this note?
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                            <form method='post' style='display: inline;'>
                                <button type='submit' name='deleteConfirmation' value='" . $row["notesId"] . "' class='btn btn-primary'>Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Button to update completion status -->
            <button type='button' class='btn btn-info' data-toggle='modal' data-target='#updateStatusModal" . $row["notesId"] . "' title='Update Status'>&#128472;</button>
            
            <!-- Modal to update completion status -->
            <div class='modal fade' id='updateStatusModal" . $row["notesId"] . "' tabindex='-1' role='dialog' aria-labelledby='updateStatusModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='updateStatusModalLabel'>Update Completion Status</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form method='post'>
                    <div class='form-group'>
                        <label for='completionStatus'>Select Status:</label>
                        <select class='form-control' name='completionStatus'>
                            <option value='Not Started' " . ($row["completion_status"] == 'Not Started' ? 'selected' : '') . ">Not Started</option>
                            <option value='Ongoing' " . ($row["completion_status"] == 'Ongoing' ? 'selected' : '') . ">Ongoing</option>
                            <option value='Completed' " . ($row["completion_status"] == 'Completed' ? 'selected' : '') . ">Completed</option>
                        </select>
                    </div>
                    <input type='hidden' name='updateCompletionStatus' value='" . $row["notesId"] . "'>
                    <input type='hidden' name='users_id' value='" . $users_id . "'> <!-- Add this line -->
                    <button type='submit' class='btn btn-primary'>Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
        </td>";
        }
        // Close the row if notesId has changed
        if ($row["notesId"] !== $prevNotesId) {
            echo "</tr>";
            $rowNumber++; // Increment row number
        }

        // Update previous notesId
        $prevNotesId = $row["notesId"];
    }

    echo "</tbody>";
}else {
    // echo "No notes found for this user.";
}

$conn->close();
?>
<script>
    $(document).ready(function () {
        // Initialize DataTable with options
        $('#notesTable').DataTable({
            "order": [[3, 'asc']], // Default sorting by the fourth column (Due Date)
            "columnDefs": [
                { "orderable": true, "targets": 0 }, // Enable sorting for the first column (No)
                { "orderable": false, "targets": [8,9, 10, 11] } // Disable sorting for the last three columns (Action, Assigned To, Assigned User Status)
            ]
        });

        $('#notesTable').on('submit', 'form.status-update-form', function (e) {
            e.preventDefault();
            
            var form = $(this);
            var isOwner = form.data('is-owner');

            // Check if the user is the owner
            if (isOwner) {
                // If owner, submit the form to update the 'notes' table
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function () {
                        // Handle success if needed
                        // You might want to update the UI or do something else
                    },
                    error: function () {
                        // Handle error if needed
                    }
                });
            } else {
                // If not the owner, submit the form to update the 'note_assignments' table
                $.ajax({
                    type: 'POST',
                    url: 'update_note_assignments.php', // Replace with the actual URL
                    data: form.serialize(),
                    success: function () {
                        // Handle success if needed
                        // You might want to update the UI or do something else
                    },
                    error: function () {
                        // Handle error if needed
                    }
                });
            }
        });

        // ... (your existing script for modal and other functionality) ...
    });
</script>

<html>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</head>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<!-- DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</html>
