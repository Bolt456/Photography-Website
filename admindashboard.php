<?php
session_start();
include 'connection.php'; // Include database connection

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    echo "<script>alert('Logged out successfully'); window.location.href='login.php';</script>";
    exit();
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Fetch total bookings
$booking_query = "SELECT COUNT(*) AS total_bookings FROM bookings";
$booking_result = mysqli_query($conn, $booking_query);
$booking_data = mysqli_fetch_assoc($booking_result);
$total_bookings = $booking_data['total_bookings'];

// Fetch total users
$user_query = "SELECT COUNT(*) AS total_users FROM users";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$total_users = $user_data['total_users'];

// Fetch total reviews
$review_query = "SELECT COUNT(*) AS total_reviews FROM reviews";
$review_result = mysqli_query($conn, $review_query);
$review_data = mysqli_fetch_assoc($review_result);
$total_reviews = $review_data['total_reviews'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SnapVerse Studios Admin Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styles */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 180px;
            background-color: #1e3a5f;
            color: #fff;
            position: fixed;
        }

        .sidebar-heading {
            padding: 1rem;
            font-size: 1.5rem;
            text-align: center;
            background-color: #162d4e;
        }

        .list-group-item {
            border: none;
            padding: 1rem;
            background-color: transparent;
            color: #fff;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #ff8c00;
            color: #fff;
        }

        .list-group-item.active {
            background-color: #345a8a;
            color: #fff;
        }

        /* Main Section Styles */
        #page-content-wrapper {
            margin-left: 180px;
            background-color: #ffffff;
            padding: 20px;
        }

        /* Dashboard Cards */
        .dashboard-card {
            border-radius: 10px;
            padding: 20px;
            color: #fff;
            text-align: center;
            transition: transform 0.2s ease-in-out;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .dashboard-card:hover {
            transform: scale(1.05);
        }

        .card-blue {
            background-color: #007bff;
        }

        .card-green {
            background-color: #28a745;
        }

        .card-yellow {
            background-color: #ffc107;
            color: #333;
        }

        .card-number {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .row .col-md-4 {
            display: flex;
            justify-content: center;
        }

        .card-container {
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">SnapVerse Studios</div>
            <div class="list-group list-group-flush">
                <a href="admindashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="martists.php" class="list-group-item list-group-item-action">Artists</a>
                <a href="mportfolio.php" class="list-group-item list-group-item-action">Portfolio</a>
                <a href="mbooking.php" class="list-group-item list-group-item-action">Bookings</a>
                <a href="musers.php" class="list-group-item list-group-item-action">Users</a>
                <a href="admindashboard.php?logout=true" class="list-group-item list-group-item-action">Logout</a>
            </div>
        </div>

        <div id="page-content-wrapper" class="p-4">
            <h1>Welcome to SnapVerse Studios Admin Panel</h1>
            <p>Manage your photography services, bookings, and customer interactions seamlessly.</p>

            <div class="container mt-4">
                <div class="row">
                    <!-- Total Bookings Card -->
                    <div class="col-md-4">
                        <div class="dashboard-card card-blue">
                            <h4>Total Bookings</h4>
                            <div class="card-number"><?php echo $total_bookings; ?></div>
                        </div>
                    </div>

                    <!-- Total Users Card -->
                    <div class="col-md-4">
                        <div class="dashboard-card card-green">
                            <h4>Total Users</h4>
                            <div class="card-number"><?php echo $total_users; ?></div>
                        </div>
                    </div>

                    <!-- Total Reviews Card -->
                    <div class="col-md-4">
                        <div class="dashboard-card card-yellow">
                            <h4>Total Reviews</h4>
                            <div class="card-number"><?php echo $total_reviews; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
