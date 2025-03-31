<?php
session_start();
include 'connection.php'; // Include the database connection file

// Admin Email and Password 
$admin_email = "snapverseadmin@gmail.com";
$admin_password = "snapverse2025"; 

$error_message = ''; // Initialize an empty error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 

    // Checks credentials for admin 
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_login_success'] = "Admin Login Successful! Redirecting to Dashboard..."; 
        
        // Redirect to login.php 
        header('Location: login.php');
        exit(); 
    } else {
        
        // Checks if details are for user 
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);    
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['login_success'] = "Login Successful! Redirecting to Home..."; // Success message
                
                // Message displayed before login 
                echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2500);</script>";
            } else {
                $error_message = 'Incorrect password'; // Set error message if password is incorrect
            }
        } else {
            $error_message = 'Enter Registered Email Or Register First'; // Set error message if email is not registered
        }
    }
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background-image: url('lens3.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: rgb(226, 227, 207);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 350px;
            height: auto;
        }

        .input-group-text {
            cursor: pointer;
        }

        .success-message {
            color: green;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            text-align: center;
            opacity: 1;
            transition: opacity 2.5s ease-out;
        }

        .admin-success-message {
            color: green;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            text-align: center;
            opacity: 1;
            transition: opacity 2.5s ease-out;
        }

        .error-message {
            color: red;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            text-align: center;
            opacity: 1;
            transition: opacity 2s ease-out;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card mx-auto">
            <form method="POST" action="login.php">
                <h2 class="text-center mb-4">User Login</h2>

                <?php
                // Display user success message if available
                if (isset($_SESSION['login_success'])) {
                    echo "<div class='success-message'>".$_SESSION['login_success']."</div>";
                    unset($_SESSION['login_success']); // Unset success message after displaying
                }

                // Display admin login success message if available
                if (isset($_SESSION['admin_login_success'])) {
                    echo "<div class='admin-success-message'>".$_SESSION['admin_login_success']."</div>";
                    unset($_SESSION['admin_login_success']); // Unset admin login success message after displaying
                    echo "<script>setTimeout(function(){ window.location.href = 'admindashboard.php'; }, 2000);</script>"; // Redirect after 2 seconds
                }

                // Display error message if there is one
                if (!empty($error_message)) {
                    echo "<div class='error-message' id='errorMessage'>".$error_message."</div>";
                }
                ?>
                
                <label for="email" class="form-label fw-semibold"></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
      
                <label for="password" class="form-label mt-3 fw-semibold"></label>
                <div class="input-group">
                    <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" required>
                    <span class="input-group-text" id="togglePassword">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-primary w-100 my-4">Submit</button>

                <div class="text-center">
                    <p>New User? <a href="register.php" class="fw-semibold">Register</a></p>
                    <p><a href="sendotp.php" class="fw-semibold">Forgot Password?</a></p> <!-- Modified link -->
                </div>
            </form> 
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password Visibility -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.className = type === 'password' ? 'bi bi-eye-slash' : 'bi bi-eye';
        });

        // Fading out the error message after 2 seconds
        setTimeout(function() {
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.style.opacity = '0';
                setTimeout(function() {
                    errorMessage.style.display = 'none'; // Hide the element after fade-out
                }, 2000);
            }
        }, 2000);
    </script>
</body>
</html>  
