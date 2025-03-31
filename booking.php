<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_message'] = "Please login to view your bookings.";
    // Show the login message and allow the page to load
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle booking cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];

    // Update booking status to "Cancelled"
    $update_query = "UPDATE bookings SET booking_status = 'cancelled' WHERE booking_id = ? AND user_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['cancel_success'] = "Booking cancelled successfully. Your amount will be refunded within 3-4 days.";
    }

    header("Location: booking.php"); // Redirect to avoid resubmission
    exit();
}

// Fetch bookings for the logged-in user
$query = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar{
            padding:8px;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1)
        }
        .container {
            padding-top: 40px;
        }

        .booking-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 15px auto;
            max-width: 600px;
            text-align: left;
        }

        .booking-status {
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 5px;
            text-transform: capitalize;
            margin-bottom: 30px; /* Increased gap here */
        }

        .status-completed {
            background-color: #28a745;
            color: white;
        }

        .status-pending {
            background-color: #ffc107;
            color: black;
        }

        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 20px;
        }

        .cancel-btn:disabled {
            background-color: #aaa;
            cursor: not-allowed;
        }

        .home-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            margin-top:20px;
        }

        .home-btn:hover {
            background-color: #0056b3;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
            border-radius: 5px;
            opacity: 1;
            transition: opacity 1s ease-in-out;
        }

        .footer {
            margin-top: 30px;
        }

        .login-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
            border-radius: 5px;
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
    <h2 class="text-center mb-4">My Bookings</h2>

    <!-- Display login message if session is set -->
    <?php if (isset($_SESSION['login_message'])): ?>
        <div class="login-message">
            <?= $_SESSION['login_message']; ?>
        </div>
        <?php unset($_SESSION['login_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['cancel_success'])): ?>
        <div class="success-message" id="successMessage">
            <?= $_SESSION['cancel_success']; ?>
        </div>
        <?php unset($_SESSION['cancel_success']); ?>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="booking-card">
                <p><strong>Booking ID:</strong> <?= htmlspecialchars($row['booking_id']) ?></p>
                <p><strong>Booking Date:</strong> <?= htmlspecialchars($row['booking_date']) ?></p>
                <p><strong>Event Date:</strong> <?= htmlspecialchars($row['event_date']) ?></p>
                <p><strong>Customer Name:</strong> <?= htmlspecialchars($row['customer_name']) ?></p>
                <p><strong>Phone Number:</strong> <?= htmlspecialchars($row['phone_number']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                <p><strong>Event Location:</strong> <?= htmlspecialchars($row['event_location']) ?></p>

                <p><strong>Package Name:</strong>
                    <?php
                    // Fetch package name from package_id
                    $package_id = $row['package_id'];
                    $package_sql = "SELECT p_name FROM packages WHERE p_id = ?";
                    $package_stmt = $conn->prepare($package_sql);
                    $package_stmt->bind_param("i", $package_id);
                    $package_stmt->execute();
                    $package_result = $package_stmt->get_result();
                    $package = $package_result->fetch_assoc();
                    echo $package ? htmlspecialchars($package['p_name']) : 'N/A';
                    ?>
                </p>

                <p><strong>Package Price:</strong> ₹<?= htmlspecialchars($row['package_price']) ?></p>
                <p>
                    <strong>Status:</strong>
                    <span class="booking-status  
                        <?= $row['booking_status'] == 'completed' ? 'status-completed' : ($row['booking_status'] == 'cancelled' ? 'status-cancelled' : 'status-pending') ?>">
                        <?= htmlspecialchars($row['booking_status']) ?>
                    </span>
                </p>

                <!-- Buttons -->
                <div class="btn-group">
                    <form method="POST" onsubmit="return confirmCancel();">
                        <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                        <button type="submit" name="cancel_booking" class="cancel-btn" 
                            <?= $row['booking_status'] == 'cancelled' ? 'disabled' : '' ?> >
                            Cancel Booking
                        </button>
                    </form>
                    <a href="index.php" class="home-btn">Back to Home</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No bookings found.
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="footer bg-light text-center text-lg-start">
    <div class="container p-4">
        <h5 class="text-uppercase">Quick Links</h5>
        <ul class="list-unstyled">
            <li><a href="index.php" class="text-dark text-decoration-none">Home</a></li>
            <li><a href="packages.php" class="text-dark text-decoration-none">Packages</a></li>
            <li><a href="contactus.php" class="text-dark text-decoration-none">Contact Us</a></li>
            <li><a href="artists.php" class="text-dark text-decoration-none">Our Artists</a></li>
        </ul>
    </div>
</footer>

<script>
    function confirmCancel() {
        return confirm("Are you sure you want to cancel the booking?");
    }
    setTimeout(() => {
        let msg = document.getElementById("successMessage");
        if (msg) msg.style.opacity = "0";
    }, 4000);
</script>

</body>
</html>
