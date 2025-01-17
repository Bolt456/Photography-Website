<?php
session_start();
include 'connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Escape user input for safety

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

       
        if ($password === $user['password']) {
            // Password matches; set session variables and redirect
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: home.php'); // Redirect to the home page
            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Enter Registered Email Or Register First');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap link css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Css Link -->
     <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="wrapper">
        <div class="container">
            <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center mb-3 bg p-3 rounded">
                <form class="form-group" method="POST" action="login.php">
                    <h2>Login</h2>
                    
                    <label for="exampleFormControlInput1" class="form-label mt-3 fw-semibold"></label>
                    <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="Email Address" required/>
          
                    <!-- Password Field -->
                            <label class="form-label mt-2 fw-semibold"></label>
                                <div class="input-group">
                                <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                                    <span class="input-group-text" id="togglePassword">
                                        <i class="bi bi-eye-slash"></i>
                    </span>
                    </div>

                    <button type="submit" class="btn btn-primary submit_btn w-100 my-4 mt-4 mb-2">Submit</button>

                    <label class="text-center d-block mt-3  fw-semibold">
                    <h6>New User ?<a href="register.php"> Register </a></h6></label>

                    <label class="text-center d-block mt-4  fw-semibold">
                    <h6><a href="forgot.php">Forgot Password</a></h6></label>

                </form> 
            </div>
        </div>
    </section>
     <!-- Bootstrap link js -->
     <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Toggle Visibility -->
      <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });
      </script>
</body>
</html>