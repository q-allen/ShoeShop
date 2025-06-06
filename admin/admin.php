<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'shoe_shop';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    // Redirect to login page if not logged in or not an admin
    header("Location: /Shoe%20Shop/login.php");
    exit();
}

// Fetch users
$result_users = $conn->query("SELECT * FROM Users");

// Fetch products
$result_products = $conn->query("SELECT * FROM products");

// Fetch shopping bags
$result_shopping_bags = $conn->query("SELECT sb.*, u.username FROM shopping_bag sb JOIN Users u ON sb.user_id = u.user_id");

// Fetch orders
$query_orders = "
    SELECT o.*, u.username 
    FROM orders o 
    JOIN Users u ON o.user_id = u.user_id
";
$result_orders = $conn->query($query_orders);

if (!$result_orders) {
    die("Error fetching orders: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0A0A18;
            color: #ffffff;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            border: 1px solid #444444;
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #1f1f2d;
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #252533;
        }

        tr:hover {
            background-color: #3a3a4c;
        }

        h2 {
            margin-top: 20px;
            color: #eaeaea;
        }

        a {
            text-decoration: none;
            color: #eaeaea;
        }

        a:hover {
            color: #ffcc00;
        }

        button {
            background-color: #ffcc00;
            border: none;
            color: #0A0A18;
            padding: 10px 15px;
            margin: 5px 2px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e0b800;
        }

        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Admin Control Panel</h1>
    
    <h2>Users</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $result_users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a>
                    <a href="delete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="add_user.php">Add New User</a>

    <h2>Products</h2>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($product = $result_products->fetch_assoc()): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['product_name']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                    <a href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="add_product.php">Add New Product</a>

    <h2>User Shopping Bags</h2>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>User</th>
            <th>Actions</th>
        </tr>
        <?php while ($bag_item = $result_shopping_bags->fetch_assoc()): ?>
            <tr>
                <td><?php echo $bag_item['id']; ?></td>
                <td><?php echo $bag_item['item_name']; ?></td>
                <td><?php echo $bag_item['item_price']; ?></td>
                <td><?php echo $bag_item['username']; ?></td>
                <td>
                    <a href="delete_bag_item.php?id=<?php echo $bag_item['id']; ?>">Remove</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Name</th>
            <th>Email</th>
            <th>Product Name</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
        <?php while ($order = $result_orders->fetch_assoc()): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['username']; ?></td>
                <td><?php echo $order['name']; ?></td>
                <td><?php echo $order['email']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['total_price']; ?></td>
                <td><?php echo $order['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2><a href="logout.php">Logout</a></h2>
</body>
</html>
