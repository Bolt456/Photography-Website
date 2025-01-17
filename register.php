<?php
  // Include Connection File
  include 'connection.php';

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone_no'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password === $confirm_password) {

        $sql = "INSERT INTO users (email, username, phone_no, password) VALUES ('$email', '$username', '$phone', '$password')";

        if ($conn->query($sql) === TRUE ) {
            echo "Registered Successfully";
            header('Location: login.php');
        } else {
            echo "Error: " .$sql . "<br>" . $conn->error;
        } 
    } else {
        echo "<script>alert('Passwords do not match')</script>";
    }
    $conn->close();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <!-- Bootstrap link css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <!-- Bootstrap Icons Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Css Link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="wrapper wrp_c">
        <div class="container">
            <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center mb-2 bg p-3 rounded">
                <form class="form-group" method="POST" action="register.php">
                    <h2>Register</h2>
                    
                    <label for="email" class="form-label mt-3 fw-semibold"></label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required/>
                    
                    <label for="username" class="form-label mt-2 fw-semibold"></label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="User Name" required/>
                    
                    <label for="phone_no" class="form-label mt-2 fw-semibold"></label>
                    <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number" required/>
                    
                    <label for="password" class="form-label mt-2 fw-semibold"></label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        <span class="input-group-text" id="togglePassword">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                    
                    <label for="confirm_password" class="form-label mt-2 fw-semibold"></label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                        <span class="input-group-text" id="toggleConfirmPassword">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary submit_btn w-100 my-4 mt-4 mb-2">Continue</button>

                    <label class="text-center d-block mt-3 fw-semibold">
                        <h6>Already Registered? <a href="login.php">Login</a></h6>
                    </label>

                    <label class="text-center d-block mt-4 fw-semibold">
                        <h6><a href="forgot.php">Forgot Password</a></h6>
                    </label>
                </form> 
            </div>
        </div>
    </section>
    <!-- Bootstrap link js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
    </script>
</body>
</html>