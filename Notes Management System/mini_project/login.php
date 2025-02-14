<!DOCTYPE html>
<html>
   
<head>
    <title >Login</title>
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
        <h2  class="notes-heading" id="notes-heading">Login</h2>
        <form method="post" action="login_process.php">
            <div class= "form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href='register.php?notesId=".$row["notesId"]." 'class = 'btn btn-danger'>Register</a>
        </form>
    </div>
</body>
</html>