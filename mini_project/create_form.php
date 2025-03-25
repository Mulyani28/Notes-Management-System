<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Notes</title>
    <link rel="shortcut icon" href="notes.jpg">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: url('https://images5.alphacoders.com/132/1327980.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            width: 700px;
            margin: 50px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-family: 'Pacifico', cursive;
            font-size: 36px;
            color: #4682b4;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input.form-control,
        select.form-control {
            width: 100%;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary-custom {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-primary-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Notes</h2>
        <form method="post" action="create_process.php">
            <!-- Hidden input for users_id -->
            <input type="hidden" name="users_id" value="<?php echo isset($_SESSION['users_id']) ? $_SESSION['users_id'] : ''; ?>">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="date">Due Date</label>
                <input type="datetime-local" name="date" id="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="priority">Priority</label>
                <select name="priority" id="priority" class="form-control" required>
                    <option value="">Select priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Select a category</option>
                    <option value="personal">Personal</option>
                    <option value="work">Work</option>
                    <option value="study">Study</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="recurrence">Recurrence</label>
                <select name="recurrence" id="recurrence" class="form-control" required>
                    <option value="none">None</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>

            <div class="form-group">
                <label for="reminder_date">Reminder Date and Time</label>
                <input type="datetime-local" name="reminder_date" id="reminder_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Completion Status</label>
                <select class="form-control" name="completion_status" required>
                    <option value="Not Started">Not Started</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="assignCheckbox">Assign to Others</label>
                <input type="checkbox" id="assignCheckbox" onclick="showAssigneesInput()">
            </div>

            <div class="form-group" id="assigneesInput" style="display: none;">
                <label for="numAssignees">Number of Assignees</label>
                <input type="number" id="numAssignees" class="form-control" min="1" value="1" onchange="generateAssigneeDropdowns()">
            </div>

            <!-- Container for dynamically generated Assign To dropdowns -->
            <div id="assigneesContainer"></div>

            <button type="submit" class="btn btn-primary">Add Notes</button>
        </form>
    </div>

    <script>
        function showAssigneesInput() {
            var assignCheckbox = document.getElementById('assignCheckbox');
            var assigneesInput = document.getElementById('assigneesInput');

            if (assignCheckbox.checked) {
                assigneesInput.style.display = 'block';
            } else {
                assigneesInput.style.display = 'none';
            }
        }

        function generateAssigneeDropdowns() {
            // Get the number of assignees from the input
            var numAssignees = document.getElementById('numAssignees').value;

            // Get the container div to append the dropdowns
            var assigneesContainer = document.getElementById('assigneesContainer');

            // Clear previous dropdowns
            assigneesContainer.innerHTML = '';

            // Generate new Assign To dropdowns based on the number of assignees
            for (var i = 0; i < numAssignees; i++) {
                // Create a new dropdown
                var dropdown = document.createElement('select');
                dropdown.name = 'assigned_to[]';
                dropdown.className = 'form-control';

                // Populate the dropdown with users from your database
                <?php
                $sqlUsers = "SELECT users_id, email FROM users_mulyani";
                $resultUsers = $conn->query($sqlUsers);

                while ($rowUser = $resultUsers->fetch_assoc()) {
                    echo 'var option = document.createElement("option");';
                    echo 'option.value = "' . $rowUser['users_id'] . '";';
                    echo 'option.text = "' . $rowUser['email'] . '";';
                    echo 'dropdown.add(option);';
                }
                ?>

                // Append the dropdown to the container
                assigneesContainer.appendChild(dropdown);
            }
        }
    </script>
</body>

</html>
