<?php
session_start();
include 'C:\xampp\htdocs\Shoe Shop\db.php'; // Ensure this path is correct

// Check if user is logged in (assumed you have a session for the logged-in user)
if (!isset($_SESSION['user_id'])) {
    header('Location: /Shoe Shop/user/login.php'); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session

// Fetch the total amount purchased by the user from the database
$total_amount = 0;

$sql = "SELECT SUM(total_price) AS total_amount FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $total_amount = $row['total_amount'] ? $row['total_amount'] : 0;
}

// Check if order details are available in the session
if (!isset($_SESSION['order_details'])) {
    header('Location: /Shoe Shop/user/bag.php');
    exit();
}

$order_details = $_SESSION['order_details'];
$items = $order_details['items']; // Assuming items are stored in session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0A0A18;
            padding: 20px;
            color: white;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            background: linear-gradient(135deg, #2a2a2a, #1c1c1c);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .order-summary {
            margin-bottom: 30px;
        }
        h2, h3 {
            margin-bottom: 15px;
        }
        p {
            line-height: 1.6;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding: 8px 0;
            border-bottom: 1px solid #444;
        }
        li:last-child {
            border-bottom: none;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Successful</h1>
        <div class="order-summary">
            <h2>Order Summary</h2>
            <p><strong>Total Amount:</strong> ₱<?php echo number_format($total_amount, 2); ?></p>
            <h3>Items Purchased:</h3>
            <ul>
                <?php foreach ($items as $item): ?>
                    <li><?php echo htmlspecialchars($item['name']); ?> - ₱<?php echo number_format($item['price'], 2); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <p>Thank you for your purchase! Your order has been placed successfully.</p>
        <a href="/Shoe Shop/user/bag.php">Go back to Shopping Bag</a>
    </div>
</body>
</html>
