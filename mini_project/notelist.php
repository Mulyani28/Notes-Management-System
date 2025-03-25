<?php
session_start(); // Start the session
include 'db.php';
// Check if the user is authenticated
$users_id = $_SESSION['users_id'];

// Fetch the username from the users table
$sqlUsername = "SELECT username FROM users_mulyani WHERE users_id = '$users_id'";
$resultUsername = $conn->query($sqlUsername);

if ($resultUsername->num_rows > 0) {
    $rowUsername = $resultUsername->fetch_assoc();
    $username = $rowUsername['username'];
} else {
    // Default to a generic username if not found
    $username = 'User';
}

$sql = "SELECT notes.*, 
               note_assignments.assigned_to,
               users_mulyani.username AS owner_username,
               assigned_users.username AS assigned_username
        FROM notes
        LEFT JOIN note_assignments ON notes.notesId = note_assignments.notesId
        LEFT JOIN users_mulyani ON notes.users_id = users_mulyani.users_id
        LEFT JOIN users_mulyani AS assigned_users ON note_assignments.assigned_to = assigned_users.users_id
        WHERE notes.users_id = '$users_id' OR note_assignments.assigned_to = '$users_id'
        ORDER BY notes.date DESC";
$result = $conn->query($sql);

$tasks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Management System</title>
    <link rel="shortcut icon" href="notes.jpg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
    <link rel="stylesheet" href="styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-gxYQ+3/CSzU1HxiDXH1j03PkT2xj2n3P8XAWf+9tNqdGKFjFfZ+qcvhOEXYzFDMY" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<style>
       body {
    background-color: #f5f5dc;
    font-family: Arial, sans-serif;
}

.container {
    max-width: auto;
    margin: 0 auto;
    padding: 20px;
}
.table th:first-child,
.table td:first-child {
    width: 7px; /* Set a fixed width for the "No" column */
}


.notes-heading {
    color: #8b4513;
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
}

.btn-primary,
.btn-secondary,
.btn-warning,
.btn-danger {
    background-color: #add8e6;
    border-color: #4682b4;
    color: #4682b4;
}

.card {
    background-color: #faf0e6;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.table {
    width: 80%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 10px;
    text-align: left;
}

.table th {
    background-color: #4682b4;
    color: #fff;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f5f5f5;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #ddd;
}

.table th:first-child,
.table td:first-child {
    width: 5px; /* Set a fixed width for the "No" column */
}

.btn-group {
    margin-bottom: 10px;
}


.card-body {
    overflow-x: auto;
}

.table {
    width: auto;
    border-collapse: collapse;
    table-layout: fixed;
}

.table th,
.table td {
    padding: 10px;
    text-align: left;

}

.table th {
    background-color: #4682b4;
    color: #fff;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f5f5f5;
}

.btn-group {
    margin-bottom: 10px;
}

#toggleCalendarButton {
    margin-top: 20px;
}

#calendar {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.navbar {
        background: linear-gradient(to right, #4682b4, #63a69f);
    }
    .navbar:hover {
        background-color: #f8f9fa;
    }

    </style>



  <script>
    $(document).ready(function() {
        // Initialize DataTable with options
        $('.table').DataTable({
            "order": [[3, 'asc']], // Default sorting by the fourth column (Due Date)
            "columnDefs": [
                { "orderable": true, "targets": 0 }, // Enable sorting for the first column (No)
                { "orderable": false, "targets": [4,5] } // Disable sorting for the last column (Action)
            ]
        });

        $('[data-toggle="modal"]').modal();
    });
</script>





<body>

    <nav class="navbar navbar-expand-lg navbar-light" style="width: auto; padding: 10px;">
    <a class="navbar-brand text-center w-100" href="#" style="font-size: 24px; color: black; text-decoration: none;">
        <span style="font-weight: bold;">Note's</span> Management
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php" style="color: white; text-decoration: none;">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="update_account.php" style="color: white; text-decoration: none;">
                    Edit Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" style="color: white; text-decoration: none;">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
        <br>

        <h2 class="notes-heading" id="notes-heading"><?php echo ucfirst(htmlspecialchars($username)) ?>'s Notes</h2>


            <a href="create_form.php" class="btn btn-primary add-button">Add Notes</a>

        <a href="assign_pages.php" class="btn btn-primary add-button">Own Notes</a>
        <div class="card mt-3" style="background-color: #c0c0c0;">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:fit-content";>No</th>
                            <th>Title</th>
                            <th>Description</th>

                            <th>Due Date</th>
                            <th>Details</th>
                           
                        
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'read.php';
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
