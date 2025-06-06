<?php
// admin.php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $category = $_POST['category'];

    $sql = "INSERT INTO products (product_name, price, image_url, category, created_at) VALUES ('$product_name', '$price', '$image_url', '$category', NOW())";

    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch categories from the database
$category_sql = "SELECT DISTINCT category FROM products"; // Adjust this if you have a categories table
$category_result = $conn->query($category_sql);
$categories = [];
if ($category_result->num_rows > 0) {
    while ($row = $category_result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0A0A18;
            color: #ffffff; /* Change text color to white for better contrast */
            margin: 20px;
        }

        h1 {
            margin-bottom: 20px; /* Space below the heading */
            color: #ffcc00; /* Brighter header color */
            font-size: 2em; /* Larger font size for emphasis */
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column; /* Arrange items in a column */
            gap: 15px; /* Space between form elements */
            max-width: 400px; /* Set a maximum width for the form */
            margin: auto; /* Center the form horizontally */
        }

        label {
            margin-bottom: 5px; /* Space between label and input */
        }

        input[type="text"], input[type="number"], select {
            background-color: #1f1f2d; /* Background color for inputs */
            color: #ffffff; /* Text color */
            border: 1px solid #444444; /* Border color */
            padding: 10px; /* Padding inside inputs */
            border-radius: 5px; /* Rounded corners */
            max-width: 100%; /* Ensure inputs don't exceed their parent width */
        }

        input[type="submit"] {
            background-color: #ffcc00; /* Button background color */
            border: none;
            color: #0A0A18; /* Button text color */
            padding: 10px 15px; /* Button padding */
            cursor: pointer;
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        input[type="submit"]:hover {
            background-color: #e0b800; /* Darker yellow on hover */
        }

        .link-container {
            display: flex;               /* Use flexbox */
            justify-content: center;     /* Center the link horizontally */
            margin-top: 20px;
            margin-left: -220px           /* Add some space above */
        }

        a {
            text-decoration: none;
            color: #eaeaea; /* Lighter color for links */
        }

        a:hover {
            color: #ffcc00; /* Change link color on hover */
        }
    </style>
</head>
<body>
    <h1>Add New Product</h1>
    <form method="POST">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>
        
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" required>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="" disabled selected style="font-family: 'Poppins', sans-serif;">Select a category</option> <!-- Placeholder option -->
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="submit" value="Add Product">
    </form>
    
    <div class="link-container">
        <a href="admin.php">Back to Admin Panel</a>
    </div>
</body>
</html>
