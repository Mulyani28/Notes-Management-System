<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit();
}

$users_id = $_SESSION['users_id'];

// Retrieve user details from the database
$sql = "SELECT * FROM users_mulyani WHERE users_id = '$users_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['email'];
    // Add more fields as needed
} else {
    echo "Error: User not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated user inputs
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    // Add more fields as needed

    // Validate and sanitize user inputs
    $newUsername = mysqli_real_escape_string($conn, $newUsername);
    $newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);

    // Use prepared statement to update user details in the users table
    $stmt = $conn->prepare("UPDATE users_mulyani SET username = ?, email = ? WHERE users_id = ?");
    $stmt->bind_param("ssi", $newUsername, $newEmail, $users_id);

    if ($stmt->execute()) {
        // Redirect to the dashboard after successful update
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <link rel="shortcut icon" href="notes.jpg">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Use either Bootstrap 4 or Bootstrap 5, not both -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 600px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            <form method="post" action="update_account.php">
                <h2 class="text-center mb-4">Update Account</h2>

                <label for="newUsername">New Username:</label>
                <input type="text" name="newUsername" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>

                <label for="newEmail">New Email:</label>
                <input type="email" name="newEmail" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>

                <!-- Add more fields as needed -->
<br>
                <button type="submit" class="btn btn-primary btn-block">Update Account</button>
            </form>
        </div>
    </div>
</body>

</html>