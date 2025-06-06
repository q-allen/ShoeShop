<?php
session_start();
include 'C:\xampp\htdocs\Shoe Shop\db.php'; // Corrected path to db.php

// Initialize the bag if it's not set yet
if (!isset($_SESSION['shopping_bag'])) {
    $_SESSION['shopping_bag'] = array();
}

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Make sure user_id is set

// If the form was submitted, add the item to the bag and the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];

    // Retrieve product details from the products table
    $stmt = $conn->prepare("SELECT product_name, price, image_url, category FROM products WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->bind_result($item_name, $item_price, $item_image, $item_category);
    $stmt->fetch();
    $stmt->close();

    if ($item_name) {
        // Add the item to the session bag
        $item = array(
            'id' => $item_id,
            'name' => $item_name,
            'price' => $item_price,
            'image' => $item_image,
            'category' => $item_category // Include category in the session
        );
        $_SESSION['shopping_bag'][] = $item;

        // Get current timestamp for added_at
        $added_at = date('Y-m-d H:i:s');

        // Insert the item into the database
        $stmt = $conn->prepare("INSERT INTO shopping_bag (item_id, item_name, item_price, item_image, category, added_at, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdsssi", $item_id, $item_name, $item_price, $item_image, $item_category, $added_at, $user_id);

        if ($stmt->execute()) {
            header('Location: /Shoe Shop/user/men.php'); // Redirect after success
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Item not found.";
    }
}

// If the remove item button is clicked, remove from both session and database
if (isset($_GET['remove'])) {
    $item_id_to_remove = intval($_GET['remove']); // Ensure this is an integer

    // Remove from session
    foreach ($_SESSION['shopping_bag'] as $key => $item) {
        if ($item['id'] == $item_id_to_remove) {
            unset($_SESSION['shopping_bag'][$key]);
            break;
        }
    }
    $_SESSION['shopping_bag'] = array_values($_SESSION['shopping_bag']); // Reindex array

    // Remove from database
    $stmt = $conn->prepare("DELETE FROM shopping_bag WHERE item_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $item_id_to_remove, $user_id);
    $stmt->execute();
    $stmt->close();

    header('Location: /Shoe Shop/user/bag.php');
    exit();
}

// Close the database connection at the end of the script
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Bag - Hinagiban</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 15px;
            border-bottom: 1px solid #ccc;
            text-align: left;
            color: white;
        }
        table th {
            background: linear-gradient(135deg, #2a2a2a, #1c1c1c);
            color: white;
        }
        table td img {
            max-width: 80px;
            border-radius: 5px;
        }
        .cart-total {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
            color: white;
        }
        .checkout-btn, .continue-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
            font-size: 16px;
            margin-right: 10px;
        }
        .checkout-btn:hover {
            background-color: #218838;
        }
        .continue-btn {
            background-color: #007bff;
        }
        .continue-btn:hover {
            background-color: #0056b3;
        }
        .remove-btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s;
            font-size: 14px;
        }
        .remove-btn:hover {
            background-color: #c82333;
        }
        .empty-cart {
            text-align: center;
            font-size: 1.2em;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Shopping Bag</h1>

        <?php if (isset($_SESSION['shopping_bag']) && count($_SESSION['shopping_bag']) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_price = 0;
                    foreach ($_SESSION['shopping_bag'] as $item) {
                        $total_price += $item['price']; ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                        <td>₱<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['category']); ?></td>
                        <td>
                            <a href="bag.php?remove=<?php echo $item['id']; ?>" class="remove-btn">Remove</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="cart-total">
                Total: ₱<?php echo number_format($total_price, 2); ?>
            </div>

            <div class="checkout">
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                <a href="/Shoe Shop/user/index.php" class="continue-btn">Continue Shopping</a>
            </div>

        <?php } else { ?>
            <p class="empty-cart">Your bag is currently empty.</p>
            <div class="back-to-products">
                <a href="/Shoe Shop/user/index.php" class="continue-btn">Back to Products</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
