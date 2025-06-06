<?php
session_start();

// Database connection
$host = 'localhost'; // Your database host
$username = 'root'; // Your database username
$password = ''; // Your database password
$database = 'shoe_shop'; // Your database name

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

// Check if an ID was passed in the URL
if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']); // Sanitize input

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM shopping_bag WHERE id = ?");
    $stmt->bind_param("i", $item_id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect to the shopping bag management page with success message
        header("Location: delete_bag_item.php?success=1");
    } else {
        // Redirect with error message
        header("Location: delete_bag_item.php?error=1");
    }

    $stmt->close();
} else {
    // Redirect if no ID was provided
    header("Location: delete_bag_item.php?error=2");
}

$conn->close();
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
            color: #ffffff; /* Change text color to white for better contrast */
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Add shadow for depth */
        }

        th, td {
            border: 1px solid #444444; /* Darker border for better contrast */
            text-align: left;
            padding: 12px; /* Increased padding for better spacing */
        }

        th {
            background-color: #1f1f2d; /* Darker header color */
            color: #ffffff; /* White text for header */
        }

        tr:nth-child(even) {
            background-color: #252533; /* Alternate row color */
        }

        tr:hover {
            background-color: #3a3a4c; /* Highlight row on hover */
        }

        h2 {
            margin-top: 20px;
            color: #eaeaea; /* Lighter color for headings */
        }

        a {
            text-decoration: none;
            color: #eaeaea; /* Lighter color for links */
        }

        a:hover {
            color: #ffcc00; /* Change link color on hover */
        }

        button {
            background-color: #ffcc00; /* Button background color */
            border: none;
            color: #0A0A18; /* Button text color */
            padding: 10px 15px; /* Button padding */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 5px 2px;
            cursor: pointer;
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        button:hover {
            background-color: #e0b800; /* Darker yellow on hover */
        }

        form {
            margin-bottom: 20px;
        }

        .message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
            background-color: #3a3a4c; /* Background for messages */
            color: #ffcc00; /* Color for message text */
        }
    </style>
</head>
<body>
    <h1>Admin Control Panel</h1>

    <?php
    // Check for success or error messages
    $message = '';
    if (isset($_GET['success'])) {
        $message = "Item successfully removed from the shopping bag.";
    } elseif (isset($_GET['error'])) {
        $message = "An error occurred while removing the item.";
    } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
        $message = "No item ID provided.";
    }

    // Display message if available
    if ($message) {
        echo "<div class='message'>$message</div>";
    }
    ?>

    <h2>User Shopping Bags</h2>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>User</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch shopping bags again for display
        $result_shopping_bags = $conn->query("SELECT sb.*, u.username FROM shopping_bag sb JOIN Users u ON sb.user_id = u.user_id");
        while ($bag_item = $result_shopping_bags->fetch_assoc()): ?>
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

    <h2><a href="logout.php">Logout</a></h2>
</body>
</html>
