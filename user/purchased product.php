<?php
session_start();
include 'C:\xampp\htdocs\Shoe Shop\db.php'; // Corrected path to db.php

// Assuming the user is logged in and user_id is stored in session
if (!isset($_SESSION['user_id'])) {
    header('Location: /Shoe Shop/user/login.php'); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's orders, including product image and name
$query = "SELECT o.id, p.product_name, o.total_price, o.status, p.image_url 
          FROM orders o 
          JOIN products p ON o.id = p.id WHERE o.user_id = ?"; // Make sure to use the correct foreign key
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle form submission for updating order status
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = $_POST['id'];
    $new_status = $_POST['status'];

    // Update the order status in the database
    $update_query = "UPDATE orders SET status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);

    if ($update_stmt === false) {
        die("Error preparing update statement: " . htmlspecialchars($conn->error));
    }

    $update_stmt->bind_param("si", $new_status, $order_id);
    $update_stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
    exit; // Ensure no further code is executed after redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hinagiban - Step Into Style</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #0A0A18;
            color: white;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
        }
        .navbar h1 {
            font-weight: 600;
            font-size: 24px;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            gap: 30px;
        }
        .navbar ul li {
            display: inline;
            font-weight: 400;
        }
        .navbar ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        .navbar ul li a:hover {
            color: gray;
        }

        .user-menu {
        position: relative; /* Necessary for dropdown positioning */
        display: inline-block; /* To allow the dropdown to position relative to the icon */
        margin-left: 20px; /* Space between user icon and the dropdown */
    }

        .dropdown-content {
            display: none; /* Hidden by default */
            position: absolute;
            right: 0; /* Aligns the dropdown to the right of the icon, so it opens to the left */
            top: 100%; /* Positions it below the icon */
            background-color: #1C1C28; /* Dark background */
            min-width: 190px; /* Width of the dropdown */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3); /* Enhanced shadow */
            z-index: 1000; /* Ensure it's on top */
            opacity: 0; /* Start with hidden opacity */
            transition: opacity 0.3s ease, transform 0.3s ease; /* Smooth transitions */
            transform: translateY(10px); /* Slightly move down */
            max-height: 200px; /* Max height for long dropdowns */
            overflow-y: auto; /* Enable scrolling if content exceeds max height */
        }

        .user-menu:hover .dropdown-content {
            display: block; /* Show dropdown on hover */
            opacity: 1; /* Fade in */
            transform: translateY(0); /* Move to original position */
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            transition: background-color 0.3s, color 0.3s; /* Smooth hover transition */
            border-radius: 4px; /* Rounded corners for dropdown items */
        }

        .dropdown-content a:hover {
            background-color: #333; /* Background change on hover */
            color: #fff; /* Ensure text remains white on hover */
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2); /* Shadow on hover */
        }

        h1 {
            color: white;
            margin-bottom: 20px;
            margin-left: 20px;
        }
        table {
            width: 98%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 20px;;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background-color: #444444;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #1c1c28;
        }
        tr:hover {
            background-color: #2b2b38;
        }
        form {
            display: inline;
        }
        select {
            padding: 5px;
            margin-right: 5px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #495057;
        }
        button {
            padding: 5px 15px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        .no-orders {
            margin-top: 20px;
            font-size: 18px;
            text-align: center;
            color: #ffffff;
        }
        .product-image {
            width: 50px; /* Adjust size as needed */
            height: auto;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <h1>hin<span style="color:#808080;">A</span>giban</h1>
        <ul>
            <li><a href="index.php">HOME</a></li>
            <li><a href="men.php">MEN</a></li>
            <li><a href="women.php">WOMEN</a></li>
            <li><a href="about.php">ABOUT</a></li>
        </ul>
        <div>
            <a href="/Shoe Shop/user/bag.php" style="margin-right: 20px;"><img src="/Shoe Shop/images/bag.png" alt="Cart" width="20"></a>
            <div class="user-menu">
                <a><img src="/Shoe Shop/images/profile.png" alt="User" width="20"></a>
                <div class="dropdown-content">
                    <a href="/Shoe Shop/user/profile.php">Profile Settings</a>
                    <a href="/Shoe Shop/user/purchased product.php">Purchased Product</a>
                    <a href="/Shoe Shop/logout.php" style= "color: red">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <h1>Your Purchased Products</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="product-image">
                        <?php echo htmlspecialchars($row['product_name']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="status" style=" font-family: 'Poppins', sans-serif;" onchange="this.form.submit()">
                                <option value="received" style=" font-family: 'Poppins', sans-serif;" <?php echo $row['status'] === 'received' ? 'selected' : ''; ?>>Received</option>
                                <option value="not_received" style=" font-family: 'Poppins', sans-serif;" <?php echo $row['status'] === 'not_received' ? 'selected' : ''; ?>>Not Received</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                            <button type="submit" style=" font-family: 'Poppins', sans-serif;">Update Status</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-orders">No orders found.</p>
    <?php endif; ?>

</body>
</html>
