<?php
session_start(); 
include 'connection.php'; 

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : 0;

// Fetching package details from database
$sql = "SELECT * FROM packages WHERE p_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $package_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$package = mysqli_fetch_assoc($result);

if (!$package) {
    echo "<h2 class='text-center text-danger mt-5'>Package not found!</h2>";
    exit;
}

// Today's Date 
$today = date('Y-m-d');

$user_id = $_SESSION['user_id'];
$sql_user = "SELECT username FROM users WHERE user_id = ?";
$stmt_user = mysqli_prepare($conn, $sql_user);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);
$user = mysqli_fetch_assoc($result_user);
$username = $user ? $user['username'] : 'Guest';

// Store package and user details in session
$_SESSION['package_id'] = $package['p_id'];
$_SESSION['package_name'] = $package['p_name'];
$_SESSION['package_price'] = $package['p_price'];
$_SESSION['customer_name'] = $username;

// Fetch booked dates
$booked_dates = [];
$bookings_query = "SELECT event_date FROM bookings";
$bookings_result = mysqli_query($conn, $bookings_query);
while ($row = mysqli_fetch_assoc($bookings_result)) {
    $booked_dates[] = date('Y-m-d', strtotime($row['event_date']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['phone'] = $_POST['phone'] ?? '';
    $_SESSION['event_date'] = $_POST['event_date'] ?? '';
    $_SESSION['event_location'] = $_POST['event_location'] ?? '';
    $_SESSION['email'] = $_POST['email'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Package - <?= htmlspecialchars($package['p_name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .booking-form {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
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
        .btn-cancel {
            background-color: #dc3545;
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
        }
        .btn-cancel:hover {
            background-color: #c82333;
        }
        #date-message {
            color: red;
            font-weight: bold;
            display: none;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 06px;
            text-align: center;
            margin-top: auto;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
        }
        .form-group {
            flex: 1;
            margin-right: 10px;
        }
        .form-group:last-child {
            margin-right: 0;
        }
        #phone-error {
            display: none;
        }
        #date-message {
            display: none;
            transition: opacity 0.5s ease;
        }
        .navbar{
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">SnapVerse Studios</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="artists.php">Artists</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="booking-form">
                <h3 class="text-center">Book Your Package</h3>
                <form action="summary.php" method="POST" onsubmit="return validatePhoneNumber()">
                    <input type="hidden" name="package_id" value="<?= $package['p_id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Selected Package</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($package['p_name']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Package Price</label>
                        <input type="text" class="form-control" value="&#8377;<?= htmlspecialchars($package['p_price']) ?>" readonly>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label">Customer Name</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($username) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Event Date</label>
                            <input type="date" class="form-control" id="event_date" name="event_date" min="<?= $today ?>" required>
                            <p id="date-message"> Services not available on this date.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Your Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label mt-3">Event Location</label>
                        <textarea class="form-control" name="event_location" placeholder="Enter event location" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-custom" id="submit-btn">Confirm Booking</button>
                        <a href="index.php" class="btn btn-cancel">Cancel Booking</a>
                    </div>

                    <div id="phone-error" class="text-danger text-center mt-2" style="display: none;">
                        Enter a valid 10-digit phone number.
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <div class="container">
        <p>© 2025 SnapVerse Studios</p>
    </div>
</div>

<script>
    function validatePhoneNumber() {
        var phone = document.getElementById('phone').value;
        var errorMessage = document.getElementById('phone-error');

        if (!/^\d{10}$/.test(phone)) {
            errorMessage.style.display = 'block';
            setTimeout(() => { errorMessage.style.display = 'none'; }, 2000);
            return false;
        }
        return true;
    }

    document.getElementById('event_date').addEventListener('change', function() {
        var selectedDate = this.value;
        var bookedDates = <?= json_encode($booked_dates); ?>;
        var message = document.getElementById('date-message');
        var submitBtn = document.getElementById('submit-btn');

        if (bookedDates.includes(selectedDate)) {
            message.style.display = 'block';
            submitBtn.disabled = true;
            setTimeout(() => { message.style.opacity = '0'; }, 1000);
            setTimeout(() => { message.style.display = 'none'; }, 2000);
        } else {
            message.style.display = 'none';
            submitBtn.disabled = false;
        }
    });
</script>

</body>
</html>
