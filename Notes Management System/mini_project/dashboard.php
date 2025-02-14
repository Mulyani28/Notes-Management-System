<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
    <link rel="stylesheet" href="styles.css"> 
    <style>
        
    </style>
</head>
<body>
<div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand mx-auto" href="#" ><b>Note Management System</b></a>
        </nav>
        <br>

        <h2 class="notes-heading" id="notes-heading">My Notes</h2>
        <a href="create_form.php" class="btn btn-primary add-button">Add Notes</a>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date</th>
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
</body>
</html>

