<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap link css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>

    <!-- Css Link -->
     <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="wrapper ">
        <div class="container">
            <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center mb-2 bg p-3 rounded">
                <form class="form-group" action="newpass.php">

                    <h3 class="text-center mb-3 mt-2">Forgot Password</h3>
                    <div class="class fw-normal mb-2 text-center"> Enter email to reset your password </div>

                    <label for="exampleFormControlInput1" class="form-label fw-semibold"></label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email Address" required/>
                     
                    <div class="d-flex justify-content-center mt-3">
                        <button type="email" class="btn btn-primary submit_btn ms-1 mt-2 mb-2 my-4" >Submit</button>
                        <button type="email" class="btn btn-secondary submit_btn2 ms-3 mt-2 mb-2 my-4">Cancel</button>   
                    </div>

                    <div class="text-center d-block mt-2">
                        <label><a href="login.php"><h6>Login</h6></a></label>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>