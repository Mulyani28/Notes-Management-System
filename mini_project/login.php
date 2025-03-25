<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="shortcut icon" href="notes.jpg">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

        .show-password-checkbox {
            margin-top: 10px;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2>Login</h2>
                <?php
                // Display error messages
                if (isset($_GET['error'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>
                <form method="post" action="login_process.php">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <input type="checkbox" class="show-password-checkbox" onclick="togglePasswordVisibility(this)">
                                    Show
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href='register.php' class='btn btn-danger'>Register</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(checkbox) {
            var passwordInput = document.getElementsByName("password")[0];
            passwordInput.type = checkbox.checked ? "text" : "password";
        }
    </script>
</body>

</html>
