<?php
session_start();
include 'connection.php'; // Database connection

// Razorpay API key
$razorpay_key = 'rzp_test_gRkl905Xsw0vdL'; // Your Razorpay test key

// Retrieve session data
$customer_name = $_SESSION['customer_name'] ?? '';
$phone_number = $_SESSION['phone'] ?? ''; 
$email = $_SESSION['email'] ?? '';
$event_location = $_SESSION['event_location'] ?? '';
$package_id = $_SESSION['package_id'] ?? '';
$package_price = $_SESSION['package_price'] ?? '';
$event_date = $_SESSION['event_date'] ?? ''; 
$user_id = $_SESSION['user_id'] ?? '';

// Ensure required data is available
if (empty($package_price) || empty($customer_name) || empty($email)) {
    echo "<script>alert('Missing booking details. Please try again.'); window.location.href='summary.php';</script>";
    exit();
}

$payment_success = false;

// If payment is successful
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store booking details in the database after successful payment
    $booking_status = 'completed';
    
    // Convert dates to "dd-mm-yyyy" format before inserting into DB
    $booking_date = date("d-m-Y"); 
    $formatted_event_date = date("d-m-Y", strtotime($event_date));

    // Insert booking details into database
    $query = "INSERT INTO bookings (booking_date, booking_status, user_id, customer_name, phone_number, email, event_location, package_id, package_price, event_date) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $booking_date, $booking_status, $user_id, $customer_name, $phone_number, $email, $event_location, $package_id, $package_price, $formatted_event_date);

    if ($stmt->execute()) {
        $payment_success = true;
    } else {
        echo "<script>alert('Error processing your booking. Please contact support.'); window.location.href='summary.php';</script>";
        exit();
    }
}

// Generate Razorpay order
$total_amount = $package_price * 100; // Convert to paise
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .success-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .success-box h2 {
            color: #28a745;
            font-weight: bold;
        }
        .details-box {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 10px;
            text-align: left;
            margin-top: 10px;
        }
        .details-box p {
            margin: 5px 0;
            font-size: 16px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($payment_success): ?>
                    <!-- Success Message -->
                   
                    <div class="success-box">
                        <h2>Payment Successful!</h2>
                        <p>Thank you, <strong><?php echo htmlspecialchars($customer_name); ?></strong>, for booking with us.</p>
                        <p>Your payment has been received successfully.</p>

                        <div class="details-box">
                            <h5><strong>📜 Booking Details:</strong></h5>
                            <p><strong>📅 Booking Date:</strong> <?php echo htmlspecialchars($booking_date); ?></p>
                            <p><strong>📍 Location:</strong> <?php echo htmlspecialchars($event_location); ?></p>
                            <p><strong>🗓 Event Date:</strong> <?php echo htmlspecialchars($formatted_event_date); ?></p>
                            <p><strong>📞 Contact:</strong> <?php echo htmlspecialchars($phone_number); ?></p>
                            <p><strong>💰 Amount Paid:</strong> ₹<?php echo htmlspecialchars($package_price); ?></p>
                        </div>

                        <p>📩 Your invoice will be sent to your email: <strong><?php echo htmlspecialchars($email); ?></strong></p>

                        <a href="index.php">Go to Home</a>
                    </div>

                <?php else: ?>
                    <!-- Payment Processing -->
                    <script>
                        function startPayment() {
                            var options = {
                                "key": "<?php echo $razorpay_key; ?>",
                                "amount": "<?php echo $total_amount; ?>",
                                "currency": "INR",
                                "name": "SnapVerse Studios",
                                "description": "Payment for Booking",
                                "handler": function () {
                                    var form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = 'payment.php';
                                    document.body.appendChild(form);
                                    form.submit();
                                },
                                "prefill": {
                                    "name": "<?php echo htmlspecialchars($customer_name); ?>",
                                    "email": "<?php echo htmlspecialchars($email); ?>",
                                    "contact": "<?php echo htmlspecialchars($phone_number); ?>"
                                }
                            };

                            var rzp1 = new Razorpay(options);
                            rzp1.open();
                        }

                        window.onload = startPayment;
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
