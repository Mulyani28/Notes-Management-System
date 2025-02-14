<!DOCTYPE html>
<html>
   
<head>
    <title >Register</title>
    <link rel="stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
    <link rel="stylesheet" href="styles.css"> 
    <style>
        h2{
            font-weight: 4000;
            color:aliceblue;
        }
    </style>
</head>
<body>
    <div class = "container">
        <h2  class="notes-heading" id="notes-heading">
            Register
        </h2>
        <form method="post" action="register_process.php">
            <div class= "form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type = "submit" class="btn btn-primary">Submit</button>
            
        </form>
    </div>
</body>
</html>