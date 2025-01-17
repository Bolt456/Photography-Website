<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <!--Bootstap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts Link -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
   
    <style>
       /* Navigation Bar Css */
    .navbar{
        background: linear-gradient(135deg, #6e8efb, #a777e3) ;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    /* Navbar Brand */
    .navbar-brand{ 
        font-size: 1.5rem;
        font-weight: bold;
        color: white !important;
    }

    .navbar-nav .nav-link {
        color: white !important;
        font-size: 1.1rem;
        transition: 0.3s;
    }

    /*  Navbar Links Hover */
    .navbar-nav .nav-link:hover{
        color: yellow !important;
        transform: scale(1.05);
    }

    /* Profile Icon */
    .profile-icon {
        font-size: 2rem;
        color : white;
        transition: color 0.3s  ease-in-out, transform 0.3s;
    }

    /* Profile Icon Hover */
    .profile-icon:hover {
        color: yellow;
        transform: scale(1.1);
    }

    /* Dropdown Menu Css */
    .dropdown-menu {
        border-radius: 8px;
        overflow: hidden;
        border: none;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* DropDown Items Css */
    .dropdown-item {
        font-size: 1rem;
        transition: background 0.3s;
    }

    /* Dropdown Item Hover */
    .dropdown-item:hover {
        background: #6e8efb;
        color: white !important;
    }
    
    /* Background Image Below the Navigation Bar*/
    .bg-container {
            background-image: url('image1.jpg'); 
            background-size: cover;
            background-position: center center; 
            min-height: 100vh; 
            margin-top: 56px; 
            padding-top: 0;
        }

    .welcome-text {
            position: relative;
            padding-top: 80px; 
            padding-right: 20px; 
            font-size: 2.5rem; 
            font-weight: bold;
            text-decoration: underline;
        }

    #about .section__header {
            font-family: 'Cinzel', serif; /* Font Name */
            font-size: 3rem; 
            font-weight: bold;
            text-align: center;
            letter-spacing: 2px; 
            padding-top: 80px;
            margin-bottom: 20px;
            color: #050a0a; 
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.4); 
            position: relative;
        }

    #about .section__header::after {
            content: '';
            display: block;
            width: 400px;
            height: 4px;
            background: #b6782d; /* Underline Color */
            margin: 15px auto 0;
            border-radius: 50px;
        } 

    /* Mission Section */ 
    #mission {
    background-image: url('blurred1.png'); 
    background-size: cover;
    background-position: center center;
    background-attachment: fixed;
    padding: 40px 0; 
    }

    .mission-container {
    background-color: rgba(0, 0, 0, 0.6); 
    padding: 40px;
        }

    #mission h3 {
    font-size: 1.5rem; 
    font-weight: bold;
    margin-bottom: 1rem;
        }

    #mission p {
    font-size: 1rem; 
    color: white; 
    margin-bottom: 1rem;
        }

    #mission .fs-6 {
    font-size: 0.95rem; 
        }
  
    </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SnapVerse Studios</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link ms-3 me-3 active" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3 active" aria-current="page" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3 active" aria-current="page" href="#">Contact Us</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle me-3 active" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="#">Wedding Shoot</a></li>
                            <li><a class="dropdown-item" href="#">Maternity Shoot</a></li>
                            <li><a class="dropdown-item" href="#">Birthday Shoot</a></li>
                            <li><a class="dropdown-item" href="#">Portraits Shoots</a></li>
                            <li><a class="dropdown-item" href="#">Product Shoot</a></li>
                            <li><a class="dropdown-item" href="#">Event Shoot</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link me-3 active" aria-current="page" href="#">Artists</a>
                    </li> 
                </ul>

                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle profile-icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Update Profile</a></li>
                        <li><a class="dropdown-item" href="#">Booking History</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="logoutUser()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Home Section -->
    <div class="bg-container" id="home">
        <div class="container"> 
            <div class="row mt-5"> 
                <div class="col-md-6 mt-5" > 
                    <h1 class="welcome-text" style="color: aliceblue;">Welcome to SnapVerse Studios</h1> 
                    <p class="" style="color: aliceblue;">"Where Photography Meets Cinematic Art"</p> 
                </div> 
            </div> 
        </div> 
    </div>

    <!-- About Us Section -->
    <div class="section_container about_container" id="about">
        <h2 class="section__header">WE CAPTURE THE MOMENTS</h2>
            
        <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                <p class="text-center fs-6">
                    "At SnapVerse Studios, we specialize in freezing those fleeting moments in time that hold immense significance for you,
                     transforming them into timeless memories that you can cherish forever."</p>
                <p class="text-center fs-6">
                    With our passion for photography and keen eye for detail, we transform ordinary moments into extraordinary memories.
                     Whether it's a milestone event, a candid portrait, or the breathtaking beauty of nature, we strive to encapsulate the essence of every moment.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Expertise & Services Section -->
    <section id="expertise" class="py-5 bg-light">
        <div class="container">
    <!-- Section Heading -->
        <h3 class="text-center custom-font fw-bold mb-3">OUR EXPERTISE & SERVICES AND MANY MORE</h3>
            <p class="text-center mb-4 fs-5">
            "We specialize in capturing life's most precious moments, from grand weddings to beautiful portraits and maternity shoots."</p>

    <!-- Expertise Images -->
        <div class="row text-center">
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card border-0 shadow">
                    <img src="wedding1.jpg" class="card-img-top img-fluid" alt="Wedding Photography">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Wedding Photography & Cinematography</h5>
                        <p class="card-text text-muted">"Turn your big day into a timeless cinematic masterpiece with our wedding photography and videography expertise."</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow">
                    <img src="portrait1.jpg" class="card-img-top img-fluid" alt="Portrait Photography">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Portrait Photography</h5>
                        <p class="card-text text-muted">"Capture the essence of your personality with our vibrant and artistic portrait sessions."</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow">
                    <img src="maternity1.jpg" class="card-img-top img-fluid" alt="Maternity Photography">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Maternity Photography</h5>
                        <p class="card-text text-muted">"Celebrate the beauty of motherhood with stunning and heartfelt maternity photographs."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Mission Section with Dark Background -->
        <section id="mission" class="py-5">
            <div class="container text-center text-white mission-container">
                <h3 class="mb-3">SnapVerse Studios</h3>
                    <p class="fs-5 mb-4">
            Founded in 2022, SnapVerse Studios is dedicated to capturing life's most precious 
            moments through the lens of passion and creativity. Our team, with over 5+ years of experience 
            in the photography industry, delivers professional services that turn fleeting moments 
            into timeless memories.</p>

            <p class="fs-6">
                At SnapVerse, we believe in delivering personalized photography experiences.
                Whether it's a wedding, portrait, or family shoot, our experts ensure your 
                memories are captured with heart and artistry. Our commitment is to provide not just 
                photographs but emotional stories through our craft.
            </p>
    </div>
</section>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function logoutUser(){
            if(confirm("Log Out of the System ?")) {
                window.location.href = "login.php";
            }
        }
    </script>
</body>
</html>
