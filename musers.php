<?php
session_start();
include 'connection.php';

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

// Fetch all users from the database
$query = "SELECT user_id, username, email, phone_no, password FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);  // Fetch all users into an associative array
$stmt->close();
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

        table {
            background-color: #f4f4f9;
            width: 100%;  /* Ensures the table takes up full width of the container */
            table-layout: fixed; /* Ensures even distribution of space */
        }

        th, td {
            word-wrap: break-word; /* Ensures long content in cells wraps properly */
            padding: 10px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #e9ecef;
        }

        .action-buttons a {
            margin: 0 5px;
        }

        /* Adjust width of User ID column */
        .user-id-column {
            width: 8%; /* Reduced width for user ID column */
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
            <h2>Manage Users</h2>
            <p>Here is the list of registered users:</p>

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="user-id-column">User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone_no']); ?></td>
                            <td><?php echo htmlspecialchars($user['password']); ?></td>
                            <td class="action-buttons">
                                <a href="#" class="btn btn-sm btn-primary" onclick="return false;">Edit</a>
                                <a href="delete_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
