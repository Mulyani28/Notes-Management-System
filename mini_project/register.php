<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="shortcut icon" href="notes.jpg">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
    <link rel="stylesheet" href="styles.css">
    <style>
       

        #password-format-message {
            margin-top: 5px;
            font-size: 14px;
            color: #6c757d;
        }

       
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
  
    </style>
</head>

<body>
<div class="container">
        <div class="card">
            <div class="card-body">
        <h2 >
            Register
        </h2>
        <form method="post" action="register_process.php">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" oninput="updatePasswordStrength()" required>
                    <button type="button" class="btn btn-outline-secondary toggle-password-btn" onclick="togglePasswordVisibility('password')">👁️</button>
                </div>
                <div id="password-strength-indicator" class="password-strength"></div>
                <div id="password-suggestions" class="password-suggestions"></div>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" class="form-control" oninput="validateConfirmPassword()" required>
                <div id="confirm-password-message" style="color: red;"></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        function validatePasswordStrength(password) {
            var passwordStrengthRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (passwordStrengthRegex.test(password)) {
                return 'strong';
            } else if (password.length >= 6) {
                return 'moderate';
            } else {
                return 'weak';
            }
        }

        function updatePasswordStrength() {
            var password = document.getElementById('password').value;
            var strengthIndicator = document.getElementById('password-strength-indicator');
            var suggestionsContainer = document.getElementById('password-suggestions');
            var strength = validatePasswordStrength(password);

            strengthIndicator.textContent = 'Password Strength: ' + strength.charAt(0).toUpperCase() + strength.slice(1);
            strengthIndicator.className = 'password-strength ' + strength;

            // Display password suggestions
            if (strength === 'weak') {
                var suggestionsMessage = 'Suggestions: At least 8 characters, including letters, numbers, and special characters. Allowed special characters: @$!%*?&';
                suggestionsContainer.textContent = suggestionsMessage;
            } else {
                suggestionsContainer.textContent = ''; // Clear suggestions if not weak
            }
        }

        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var toggleBtn = document.querySelector('.toggle-password-btn');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '👁️';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁️';
            }
        }

        function validateConfirmPassword() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var confirmMessage = document.getElementById('confirm-password-message');

            if (password === confirmPassword) {
                confirmMessage.innerHTML = 'Password Match';
                confirmMessage.style.color = 'green';
            } else {
                confirmMessage.innerHTML = 'Password does not match';
                confirmMessage.style.color = 'red';
            }
        }

        function validateForm() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                alert("Passwords do not match");
                return false;
            }

            // Additional form validation logic can be added here

            return true;
        }
    </script>
</body>

</html>
