<?php
session_start();

// Check if the user is logged in (this is just a placeholder, update with your own logic)
$isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true;

// Database connection (update with your own credentials)
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "shoe_shop"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's - Hinagiban</title>
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
            position: relative; /* Position relative to manage absolute child */
            display: inline-block; /* Allow dropdown to position correctly */
        }

        .dropdown-content {
            display: none; /* Hidden by default */
            position: absolute;
            right: 0; /* Aligns the dropdown to the right of the icon */
            top: 100%; /* Positions it below the icon */
            background-color: #1C1C28; /* Dark background */
            min-width: 190px; /* Width of the dropdown */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3); /* Enhanced shadow */
            z-index: 1000; /* Ensure it's on top */
            opacity: 0; /* Start with hidden opacity */
            transition: opacity 0.3s ease, transform 0.3s ease; /* Smooth transitions */
            transform: translateY(10px); /* Slightly move down */
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
        
        /* Men's Shoes Section */
        .mshoe-grid {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            margin-top: 20px;
        }

        .shoe-item {
            background-image: url("/Shoe Shop/images/women/women.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 200px; /* Adjusted width */
            padding: 10px; /* Adjusted padding */
            text-align: center;
            background-color: #1C1C28;
            border-radius: 10px;
            margin: 10px; /* Maintain space between items */
        }

        .shoe-item img {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 10px;
        }

        .shoe-item h2 {
            font-size: 16px; /* Adjusted font size */
            margin-bottom: 5px; /* Adjusted margin */
        }

        .shoe-item .price {
            font-size: 14px; /* Adjusted font size */
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Button Styling */
        button {
            background-color: #fff;
            color: #0A0A18;
            padding: 10px 20px; /* Adjusted padding */
            border: none;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 12px; /* Adjusted font size */
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #808080;
            color: white;
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
        }

        button:active {
            transform: scale(0.98);
            box-shadow: none;
        }

        /* Notification Style */
        .notification {
            display: none; /* Initially hidden */
            background-color: #4CAF50; /* Green for success */
            color: white;
            padding: 15px;
            position: fixed;
            top: 20px;
            right: 20px;
            border-radius: 5px;
            z-index: 1000;
            opacity: 0; /* Start hidden */
            transition: opacity 0.5s ease-in-out; /* Smooth transition for fading */
        }

    </style>
    <script>
    function addToBag(itemId, shoeName, price, image, category) {
        const notification = document.querySelector('.notification');
        notification.innerText = `${shoeName} has been added to your bag.`;
        
        // Show the notification immediately
        notification.style.display = 'block';
        notification.style.opacity = '1'; // Fade in
        
        // Set a timeout to hide it after 8 seconds
        setTimeout(() => {
            notification.style.opacity = '0'; // Start fade out
            setTimeout(() => {
                notification.style.display = 'none'; // Hide after fading out
            }, 8000); // Wait for fade out to complete
        }, 500); // Show for 8 seconds

        // Create a form dynamically to submit the shoe data to PHP
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/Shoe Shop/user/bag.php'; // Form will submit to bag.php

        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'item_id';
        idInput.value = itemId;
        form.appendChild(idInput);

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'item_name';
        nameInput.value = shoeName;
        form.appendChild(nameInput);

        const priceInput = document.createElement('input');
        priceInput.type = 'hidden';
        priceInput.name = 'item_price';
        priceInput.value = price;
        form.appendChild(priceInput);

        const imageInput = document.createElement('input');
        imageInput.type = 'hidden';
        imageInput.name = 'item_image';
        imageInput.value = image;
        form.appendChild(imageInput);

        document.body.appendChild(form);
        form.submit();
    }
    </script>
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

    <h1 style="text-align: center; margin-top: 30px;">Men's Shoes</h1>

    <div class="mshoe-grid">
        <?php
        // Fetch men's products from the database
        $sql = "SELECT * FROM products WHERE category = 'men'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="shoe-item">';
                echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['product_name']) . '">';
                echo '<h2>' . htmlspecialchars($row['product_name']) . '</h2>';
                echo '<div class="price">₱' . htmlspecialchars($row['price']) . '</div>';
                echo '<button onclick="addToBag(' . htmlspecialchars($row['id']) . ', \'' . htmlspecialchars($row['product_name']) . '\', \'' . htmlspecialchars($row['price']) . '\', \'' . htmlspecialchars($row['image_url']) . '\', \'men\')">Add to Bag</button>';
                echo '</div>';
            }
        } else {
            echo '<div>No products found in this category.</div>';
        }

        $conn->close();
        ?>
    </div>

    <div class="notification"></div>
</body>
</html>
