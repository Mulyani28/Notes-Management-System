<!DOCTYPE html>
<html>

<head>
    <title>Edit Notes</title>
    <link rel="shortcut icon" href="notes.jpg">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://images5.alphacoders.com/132/1327980.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            width: 700px;
            margin: 50px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            width: 600px; 
            border-radius: 10px;
        }

        .card-body {
            padding: 30px;
           
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

        label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #4682b4;
            border-color: #4682b4;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #305f86;
            border-color: #305f86;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            font-weight: bold;
        }

        .btn-danger:hover {
            background-color: #b02a37;
            border-color: #b02a37;
        }
    </style>
</head>

<body>
<div class="container">
        <div class="card">
            <div class="card-body">
        <h2>Edit Notes</h2>
        <?php
        include 'db.php';

        if (isset($_GET['notesId'])) {
            $id = $_GET['notesId'];
            $sql = "SELECT * FROM notes WHERE notesId=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
                <form method="post" action="update_process.php">
                    <input type="hidden" name="notesId" value="<?php echo $row['notesId']; ?>">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $row['title']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <input type="text" name="content" class="form-control" value="<?php echo $row['content']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Due Date:</label>
                        <input type="datetime-local" name="date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['date'])); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Priority</label>
                        <select name="priority" class="form-control" required>
                            <option value="low" <?php echo ($row['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?php echo ($row['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?php echo ($row['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
                            <option value="urgent" <?php echo ($row['priority'] == 'urgent') ? 'selected' : ''; ?>>Urgent</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control" required>
                            <option value="" disabled>Select a category</option>
                            <option value="personal" <?php echo ($row['category'] == 'personal') ? 'selected' : ''; ?>>Personal</option>
                            <option value="work" <?php echo ($row['category'] == 'work') ? 'selected' : ''; ?>>Work</option>
                            <option value="study" <?php echo ($row['category'] == 'study') ? 'selected' : ''; ?>>Study</option>
                            <!-- Add more categories as needed -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reminder Date and Time</label>
                        <input type="datetime-local" name="reminder_date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['reminder_date'])); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                </form>
        <?php
            } else {
                echo "No Notes was found.";
            }
        } else {
            echo "Invalid request.";
        }
        $conn->close();
        ?>
    </div>
</body>

</html>
