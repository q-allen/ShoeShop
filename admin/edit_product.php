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

$product_id = $_GET['id'];
$product_result = $conn->query("SELECT * FROM products WHERE id = $product_id");
$product = $product_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $category = $_POST['category'];

    $sql = "UPDATE products SET product_name = '$product_name', price = '$price', image_url = '$image_url', category = '$category' WHERE id = $product_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0A0A18;
            color: #ffffff; 
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center align content */
        }

        h1 {
            margin: 20px 0;
            color: #ffcc00; /* Brighter header color */
            font-size: 2em; /* Larger font size for emphasis */
        }

        form {
            background-color: #1f1f2d; /* Background color for the form */
            padding: 20px;
            border-radius: 8px; /* Rounded corners for the form */
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.5); /* Shadow for depth */
            width: 100%;
            max-width: 400px; /* Max width for form */
            margin-bottom: 20px; /* Space below form */
        }

        label {
            margin-bottom: 10px;
            font-weight: bold; /* Bold labels */
            display: block; /* Make labels block elements */
            color: #eaeaea; /* Lighter color for labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="submit"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px; /* Space around inputs */
            border: 1px solid #444444; /* Darker border */
            border-radius: 5px; /* Rounded corners */
            font-size: 1em; /* Consistent font size */
            color: #0A0A18; /* Text color inside inputs */
            background-color: #ffffff; /* White background for inputs */
        }

        select {
            background-color: #ffffff; /* White background for select */
            cursor: pointer; /* Change cursor to pointer */
            transition: border-color 0.3s; /* Smooth border color transition */
        }

        select:hover {
            border-color: #ffcc00; /* Change border color on hover */
        }

        input[type="submit"] {
            background-color: #ffcc00; /* Button background color */
            color: #0A0A18; /* Button text color */
            cursor: pointer; /* Change cursor on hover */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        input[type="submit"]:hover {
            background-color: #e0b800; /* Darker yellow on hover */
        }

        .link-container {
            display: flex;               /* Use flexbox */
            justify-content: center;     /* Center the link horizontally */
            margin-top: 20px;
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
    <h1>Edit Product</h1>
    <form method="POST">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" required>
        
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="men" <?php echo ($product['category'] == 'men') ? 'selected' : ''; ?>>Men</option>
            <option value="women" <?php echo ($product['category'] == 'women') ? 'selected' : ''; ?>>Women</option>
        </select>
        
        <input type="submit" value="Update Product">
    </form>
    <div class="link-container">
        <a href="admin.php">Back to Admin Panel</a>
    </div>
</body>
</html>
