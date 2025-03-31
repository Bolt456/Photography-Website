<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get username based on user_id
$query = "SELECT username FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$username = $user ? $user['username'] : 'Guest';

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    // Insert review into the database
    $insert_query = "INSERT INTO reviews (user_id, username, review_text, rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("issi", $user_id, $username, $review_text, $rating);

    if ($stmt->execute()) {
        $_SESSION['review_success'] = "Your review has been submitted successfully!";
        
        // Redirect after submission to prevent resubmission on page refresh
        header("Location: review.php");
        exit();
    }
}

// Fetch all reviews
$query_reviews = "SELECT * FROM reviews ORDER BY review_date DESC";
$reviews_result = $conn->query($query_reviews);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: white;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: black;
            text-decoration: none;
            font-weight: normal;
        }

        .container {
            margin-top: 50px;
            max-width: 900px;
            display: flex;
            justify-content: space-between;
        }

        .review-form {
            width: 45%;
        }

        .reviews-list {
            width: 50%;
        }

        .review-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .review-card h5 {
            color: #008080;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            transition: opacity 3s ease-in-out;
        }

        .review-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .review-input:focus {
            border-color: #008080;
            outline: none;
        }

        .review-btn {
            background-color: #008080;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .review-btn:hover {
            background-color: #006666;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }

        .footer a {
            text-decoration: none;
            color: #008080;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .review-form, .reviews-list {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">SnapVerse Studios</a>
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

<!-- Main Content -->
<div class="container">
    <!-- Review Submission Form (Left Side) -->
    <div class="review-form">
        <div class="review-card">
            <h2 class="text-center mb-4">Submit Your Review</h2>

            <!-- Success Message -->
            <?php if (isset($_SESSION['review_success'])): ?>
                <div class="success-message" id="successMessage">
                    <?= $_SESSION['review_success']; ?>
                </div>
                <?php unset($_SESSION['review_success']); ?>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label fs-5">Username</label>
                    <input type="text" class="form-control review-input" id="username" name="username" value="<?= htmlspecialchars($username) ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label fs-5">Rating</label>
                    <input type="number" class="form-control review-input" id="rating" name="rating" min="1" max="5" required>
                </div>

                <div class="mb-3">
                    <label for="review_text" class="form-label fs-5">Your Review</label>
                    <textarea class="form-control review-input" id="review_text" name="review_text" rows="4" required></textarea>
                </div>

                <button type="submit" name="submit_review" class="review-btn">Submit Review</button>
            </form>
        </div>
    </div>

    <!-- Reviews List (Right Side) -->
    <div class="reviews-list">
        <h3 class="text-left mb-3">Reviews</h3>

        <?php if ($reviews_result->num_rows > 0): ?>
            <?php while ($row = $reviews_result->fetch_assoc()): ?>
                <div class="review-card">
                    <h5><?= htmlspecialchars($row['username']) ?> (Rating: <?= htmlspecialchars($row['rating']) ?>/5)</h5>
                    <p><?= nl2br(htmlspecialchars($row['review_text'])) ?></p>
                    <p><small>Reviewed on <?= htmlspecialchars($row['review_date']) ?></small></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No reviews yet.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Links Section -->
<footer class="bg-light text-center text-lg-start mt-5">
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

<script>
    setTimeout(() => {
        let msg = document.getElementById("successMessage");
        if (msg) msg.style.opacity = "0";
    }, 3000);
</script>

</body>
</html>
