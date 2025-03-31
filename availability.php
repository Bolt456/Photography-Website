<?php
include 'connection.php'; // Include database connection

// Initialize message variable
$message = '';
$event_date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_date = $_POST['event_date']; // Get user-selected date
    $formatted_date = date('d-m-Y', strtotime($event_date)); // Convert to DD-MM-YYYY

    // Check if the date is already booked
    $sql = "SELECT * FROM bookings WHERE event_date = '$formatted_date'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $message = "<p id='message' class='text-danger mt-2 fade-out'>The selected date is NOT available for booking.</p>";
    } else {
        $message = "<p id='message' class='text-success mt-2 fade-out'>The selected date is available for booking!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Availability - SnapVerse Studios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .container {
            flex: 1;
        }

        .availability-form {
            background: #ffffff;
            margin-top: 60px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        /* Smooth fade-out effect */
        .fade-out {
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .hidden {
            opacity: 0;
        }

        footer {
            margin-top: auto;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">SnapVerse Studios</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="home.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
                    <li class="nav-item"><a class="nav-link" href="artists.php">Artists</a></li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="availability-form">
                <div class="form-title text-center">Check Booking Availability</div>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Select Event Date</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" min="<?php echo date('Y-m-d'); ?>" required value="<?php echo isset($_POST['event_date']) ? $_POST['event_date'] : ''; ?>">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-custom">Check Availability</button>
                    </div>
                </form>
                <?= $message ?>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light text-center text-lg-start mt-4">
    <div class="container p-4">
        <h5 class="text-uppercase">Quick Links</h5>
        <ul class="list-unstyled">
            <li><a href="index.php" class="text-dark text-decoration-none">Home</a></li>
            <li><a href="packages.php" class="text-dark text-decoration-none">Packages</a></li>
            <li><a href="contactus.php" class="text-dark text-decoration-none">Contact Us</a></li>
            <li><a href="artists.php" class="text-dark text-decoration-none">Our Artists</a></li>
        </ul>
    </div>
    <div class="text-center p-3 bg-dark text-white">
        © 2025 SnapVerse Studios
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    
    setTimeout(function() {
        var message = document.getElementById('message');
        if (message) {
            message.classList.add('hidden');
            setTimeout(function() {
                message.style.display = 'none';
            }, 1000); 
        }
    }, 3000);
</script>

</body>
</html>
