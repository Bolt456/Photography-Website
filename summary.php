<?php
include 'connection.php'; // Include the database connection file
session_start(); // Start the session

// If form data is not set, redirect to the booking page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['package_name'] = $_SESSION['package_name'] ?? '';
    $_SESSION['package_price'] = $_SESSION['package_price'] ?? '';
    $_SESSION['phone'] = $_POST['phone'] ?? '';
    $_SESSION['event_date'] = isset($_POST['event_date']) ? date("d-m-Y", strtotime($_POST['event_date'])) : '';
    $_SESSION['event_location'] = $_POST['event_location'] ?? '';
    $_SESSION['email'] = $_POST['email'] ?? '';
    $_SESSION['customer_name'] = $_SESSION['customer_name'] ?? '';
}

// Retrieve booking details from session
$package_name = $_SESSION['package_name'] ?? '';
$package_price = $_SESSION['package_price'] ?? '';
$phone = $_SESSION['phone'] ?? '';
$event_date = $_SESSION['event_date'] ?? '';
$event_location = $_SESSION['event_location'] ?? '';
$email = $_SESSION['email'] ?? '';
$customer_name = $_SESSION['customer_name'] ?? '';
$package_id = $_SESSION['package_id'] ?? '';

// Redirect to avoid form resubmission issue
if (!isset($_SESSION['redirected_summary'])) {
    $_SESSION['redirected_summary'] = true;
    header("Location: summary.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .summary-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        <div class="col-md-8">
            <div class="summary-card">
                <div class="form-title text-center mb-4">
                    <h3>Booking Summary</h3>
                </div>

                <div class="mb-3">
                    <strong>Customer Name:</strong> <?= htmlspecialchars($customer_name) ?>
                </div>
                <div class="mb-3">
                    <strong>Phone Number:</strong> <?= htmlspecialchars($phone) ?>
                </div>
                <div class="mb-3">
                    <strong>Selected Package:</strong> <?= htmlspecialchars($package_name) ?>
                </div>
                <div class="mb-3">
                    <strong>Package Price:</strong> &#8377;<?= htmlspecialchars($package_price) ?>
                </div>
                <div class="mb-3">
                    <strong>Event Date:</strong> <?= htmlspecialchars($event_date) ?>
                </div>
                <div class="mb-3">
                    <strong>Event Location:</strong> <?= htmlspecialchars($event_location) ?>
                </div>
                <div class="mb-3">
                    <strong>Your Email:</strong> <?= htmlspecialchars($email) ?>
                </div>

                <div class="text-center">
                    <a href="payment.php" class="btn btn-custom">Make Payment</a>
                </div>
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

</body>
</html>

<?php

unset($_SESSION['redirected_summary']);
session_write_close();
?>
