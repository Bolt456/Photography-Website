<?php
session_start();

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

// Database connection
include 'connection.php';

// Fetch bookings from database
$sql = "SELECT * FROM bookings ORDER BY booking_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - SnapVerse Studios</title>
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

        /* Table Styles */
        table {
            background-color: #f4f4f9;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">SnapVerse Studios</div>
            <div class="list-group list-group-flush">
                <a href="admindashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="martists.php" class="list-group-item list-group-item-action">Artists</a>
                <a href="mportfolio.php" class="list-group-item list-group-item-action">Portfolio</a>
                <a href="mbooking.php" class="list-group-item list-group-item-action active">Bookings</a>
                <a href="musers.php" class="list-group-item list-group-item-action">Users</a>
                <a href="admindashboard.php?logout=true" class="list-group-item list-group-item-action">Logout</a>
            </div>
        </div>

        <div id="page-content-wrapper" class="p-4">
            <h2>Manage Bookings</h2>
            <p>View and manage all bookings made by customers.</p>
            
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Event Location</th>
                        <th>Package Price</th>
                        <th>Event Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['booking_id']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo ucfirst($row['booking_status']); ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['event_location']; ?></td>
                            <td><?php echo $row['package_price']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
