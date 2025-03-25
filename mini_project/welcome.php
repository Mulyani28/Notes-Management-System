<?php
    session_start();

    if(!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="shortcut icon" href="notes.jpg">

    <link rel="stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $username; ?></h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
