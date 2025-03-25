<?php
// Read tasks from the database
include 'db.php';

// Start the session
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['users_id'])) {
    // Redirect or handle the case where the user is not authenticated
    header("Location: login.php");
    exit();
}

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

$sql = "SELECT * FROM notes WHERE users_id = '$users_id'";
$result = $conn->query($sql);

$tasks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

$tasksPastReminder = array_filter($tasks, function ($task) {
    $reminderDate = strtotime($task['reminder_date']);
    $currentDate = strtotime(date('Y-m-d H:i:s'));
    return $reminderDate < $currentDate;
});
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="shortcut icon" href="notes.jpg">

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
    width: 10px; /* Set a fixed width for the "No" column */
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

    .navbar-brand {
        font-family: 'Arial', sans-serif;
        font-size: 24px;
        color: white;
        text-decoration: none;
        padding: 10px;
    }

    .navbar-brand span {
        font-weight: bold;
    }

    .navbar-nav .nav-item {
        margin-right: 10px;
    }

    .navbar-nav .nav-link {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease-in-out;
    }

    .navbar-nav .nav-link:hover {
        color: #f8f9fa;
    }

    </style>

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



</head>
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
    <h2 class="notes-heading" id="notes-heading"><?php echo ucfirst(htmlspecialchars($username)) ?>'s Notes</h2>



        <a href="notelist.php" class="btn btn-danger float-right">List Notes</a>

        <!-- Add Note Button -->
        <!-- Add Note Button -->
    <a href="create_form.php" class="btn btn-primary">Add Note</a>
   

<!-- Add Notes Form -->
<!-- Displaying cards for notes with achieved reminder_date -->  <div class="card" style="width: 80%; margin: 0 auto; background-color: #f5f5f5; padding: 20px;">
    <h2 class="notes-heading" id="notes-heading" style="color: #4682b4; text-align: center;">Reminder</h2>
    <div class="row">
        <?php
        foreach ($tasksPastReminder as $task) {
            // Check if the completion status is "DONE" and the due date has passed
            if ($task['completion_status'] === 'Completed' && strtotime($task['date']) < strtotime('now')) {
                continue; // Skip rendering the card for this task
            }
        ?>
            <div class="col-md-6 mb-4">
                <div class="card" style="width: 100%; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($task['content']); ?></p>
                        <p class="card-text"><strong>Due Date:</strong> <?php echo htmlspecialchars($task['date']); ?></p>
                        <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($task['category']); ?></p>
                        <p class="card-text"><strong>Reminder Date:</strong> <?php echo htmlspecialchars($task['reminder_date']); ?></p>
                        <p class="card-text"><strong>Completion Status:</strong> <span id="completionStatus_<?php echo $task['notesId']; ?>"><?php echo htmlspecialchars($task['completion_status']); ?></span></p>
                        
                    </div>
                    <div class="card-footer" style="background-color: #4682b4; padding: 10px; border-radius: 0 0 10px 10px;">
                        <div class="btn-group" role="group">
                            <!-- Add other buttons here if needed -->
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>




<!-- Card containing the table -->

<div id="calendar" ></div>

</div>
    </div>

    <!-- Bootstrap Modal for Note Details -->
    <div class="modal fade" id="noteDetailsModal" tabindex="-1" role="dialog" aria-labelledby="noteDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noteDetailsModalLabel">Note Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="noteDetailsBody">
                    <!-- Note details will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
   

<script>
    
   $(document).ready(function () {
        var calendarVisible = false;

        // Initialize DataTable
        $('#notesTable').DataTable();

        // Initialize FullCalendar
        var events = <?php echo json_encode($tasks); ?>;

        var calendar = $('#calendar').fullCalendar({
            events: events.map(function (task) {
                return {
                    title: task.title,
                    start: task.date,
                    // Add other properties like end, color, etc.
                    noteDetails: task,
                    completionStatus: task.completion_status // Add completion status
                };
            }),
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                // Handle date selection (e.g., show a pop-up for adding a new task)
                alert('Selected ' + start.format('MMMM DD, YYYY'));
            },
            // Customize other calendar settings as needed
            eventClick: function (event) {
                // Handle event click (e.g., show a pop-up with note details)
                var noteDetails = event.noteDetails;
                if (noteDetails) {
                    // You can customize how you want to display the note details
                    $('#noteDetailsModal').modal('show');
                    $('#noteDetailsBody').html(`
                        <p><strong>Title:</strong> ${noteDetails.title}</p>
                        <p><strong>Content:</strong> ${noteDetails.content}</p>
                        <p><strong>Due Date:</strong> ${noteDetails.date}</p>
                        <p><strong>Category:</strong> ${noteDetails.category}</p>
                        <p><strong>Reminder Date:</strong> ${noteDetails.reminder_date}</p>
                        <p><strong>Completion Status:</strong> ${noteDetails.completion_status}</p>
                        <!-- Add more details as needed -->
                    `);
                }
            },
            eventRender: function (event, element) {
                // Customize event rendering based on completion status
                if (event.completionStatus === 'Not Started') {
                    element.css('background-color', 'red'); // Light Red
                } else if (event.completionStatus === 'Ongoing') {
                    element.css('background-color', 'blue'); // Light Yellow
                } else if (event.completionStatus === 'Completed') {
                    element.css('background-color', 'green'); // Light Green
                }
                // Add more conditions/colors as needed
            }
        });

        // Toggle visibility of Calendar
        $('#toggleCalendarButton').click(function () {
            $('#calendar').toggle();
        });

        // Initialize Bootstrap Datepicker for date input fields in the table
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        // Handle date change in the table and update the FullCalendar
        $('.datepicker').change(function () {
            var rowIndex = $(this).closest('tr').index();
            var selectedDate = $(this).val();
            var calendarEvent = events[rowIndex];

            if (calendarEvent) {
                calendarEvent.start = selectedDate;
                $('#calendar').fullCalendar('updateEvent', calendarEvent);
            }
        });
    });
</script>




</body></html>
