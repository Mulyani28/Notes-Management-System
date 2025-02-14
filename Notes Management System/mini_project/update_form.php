<!DOCTYPE html>
<html>

<head>
    <title>Edit Notes</title>
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
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input.form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Notes</h2>
        <?php
        include 'db.php';

        if (isset($_GET['notesId'])) {
            $id = $_GET['notesId'];
            $sql = "SELECT * FROM notes WHERE notesId=$id";
            $result = $conn->query($sql);

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
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" value="<?php echo $row['date']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                </form>
        <?php
            } else {
                echo "Notes not found.";
            }
        } else {
            echo "Invalid request.";
        }
        $conn->close();
        ?>
    </div>
</body>

</html>
