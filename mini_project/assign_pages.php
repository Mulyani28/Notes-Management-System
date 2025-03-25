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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-gxYQ+3/CSzU1HxiDXH1j03PkT2xj2n3P8XAWf+9tNqdGKFjFfZ+qcvhOEXYzFDMY" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom styles if needed -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
  <!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<!-- DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

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


        
    <button onclick="goBack()" class="btn btn-secondary float-right">Go Back</button>
    <a href="create_form.php" class="btn btn-primary add-button ">Add Notes</a>

           


            <div class="card-body">

                <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width:fit-content";>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'assign_to.php'; // Include the assigned_notes.php file
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
        function goBack() {
            window.history.back();
        }
        $(document).ready(function () {
        // Initialize DataTable with options
        $('#notesTable').DataTable({
            "order": [[3, 'asc']], // Default sorting by the fourth column (Due Date)
            "columnDefs": [
                { "orderable": true, "targets": 0 }, // Enable sorting for the first column (No)
                // Disable sorting for the last three columns (Action, Assigned To, Assigned User Status)
            ]
        });

        // ... (your existing script for modal and other functionality) ...
    });
    </script>
</body>
</html>
