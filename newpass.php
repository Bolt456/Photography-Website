<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
    <!-- Bootstrap link css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>

    <!-- Css Link -->
     <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="wrapper">
        <div class="container">
            <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center mb-2 bg p-3 rounded">
                <form class="form-group" action="login.php">
                    <h3>Set up a New Password</h3>
                    
                    <label for="exampleFormControlInput1" class="form-label mt-2 fw-semibold"></label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Password" required/>
          
                    <label for="exampleFormControlInput1" class="form-label mt-2 fw-semibold"></label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" placeholder=" Comfirm Password" required/>

                    <button type="submit" class="btn btn-primary submit_btn w-100 my-4 mt-4 mb-2">Submit</button>

                    <label class="text-center d-block mt-2 fw-semibold"> 
                    <h6> Already Set Your Password ? <a href="login.php">Login</a></h6></label>

                </form> 
            </div>
        </div>
    </section>
     <!-- Bootstrap link js -->
     <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>