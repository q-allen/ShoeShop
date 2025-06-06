<?php
session_start();
include 'C:\xampp\htdocs\Shoe Shop\db.php'; // Ensure this path is correct

// Initialize total_price
$total_price = 0;

// Check if the shopping bag is empty
if (isset($_SESSION['shopping_bag']) && count($_SESSION['shopping_bag']) > 0) {
    foreach ($_SESSION['shopping_bag'] as $item) {
        $total_price += $item['price'];
    }
} else {
    // Redirect to the shopping bag page if the bag is empty
    header('Location: /Shoe Shop/user/bag.php');
    exit();
}

// Handle form submission for checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['email'], $_POST['address'], $_POST['payment_method'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method']; // Capture the selected payment method

    // Assuming you have a way to get the user ID, e.g., from the session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Insert the order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, total_price, payment_method, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error); // Add error handling
    }

    // Bind parameters (s = string, d = double, i = integer)
    $stmt->bind_param("sssdsi", $name, $email, $address, $total_price, $payment_method, $user_id);

    if ($stmt->execute()) {
        // Store order details in session for order_success.php
        $_SESSION['order_details'] = [
            'total_price' => $total_price,
            'items' => $_SESSION['shopping_bag']
        ];

        // Clear the shopping bag in the session
        unset($_SESSION['shopping_bag']);

        // Clear the shopping bag from the database
        $session_id = session_id(); // Get the current session ID
        $delete_stmt = $conn->prepare("DELETE FROM shopping_bag WHERE user_id = ?");
        $delete_stmt->bind_param("s", $user_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        // Redirect to a success page
        header('Location: /Shoe Shop/user/order_success.php');
        exit();
    } else {
        $error_message = "Error processing your order: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0A0A18;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #2a2a2a, #1c1c1c);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }
        .cart-summary {
            margin-bottom: 20px;
            color: white;
        }
        .error-message {
            color: red;
        }
        label {
            color: white;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .radio-input {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            cursor: pointer;
            color: white;
        }
        .radio-input input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        .radio-checkmark {
            height: 25px;
            width: 25px;
            background-color: #eee;
            border-radius: 50%;
            margin-right: 10px;
        }
        .radio-input input:checked ~ .radio-checkmark {
            background-color: #28a745;
        }
        .payment-icon {
            width: 30px; /* Adjust the size as needed */
            height: auto;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>

        <div class="cart-summary">
            <p><strong>Total Amount:</strong> ₱<?php echo number_format($total_price, 2); ?></p>
        </div>

        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>

        <form action="checkout.php" method="post">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="address">Shipping Address</label>
            <textarea id="address" name="address" rows="4" required></textarea>

            <!-- Payment Method Selection -->
            <label for="payment_method">Select Payment Method</label>

            <div class="radio-input">
                <input type="radio" id="gcash" name="payment_method" value="GCash" required>
                <span class="radio-checkmark"></span>
                <img src="/Shoe Shop/images/gcash.png" alt="GCash" class="payment-icon">
                <label for="gcash">GCash</label>
            </div>

            <div class="radio-input">
                <input type="radio" id="cod" name="payment_method" value="Cash on Delivery" required>
                <span class="radio-checkmark"></span>
                <img src="/Shoe Shop/images/cod.png" alt="Cash on Delivery" class="payment-icon">
                <label for="cod">Cash on Delivery</label>
            </div>

            <input type="submit" value="Place Order">
        </form>
    </div>
</body>
</html>
