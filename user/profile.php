<?php
// Start the session at the very top before any HTML output
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "shoe_shop"); // Update with your actual DB credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming user ID is stored in the session
$userId = $_SESSION['user_id']; // Ensure user_id is stored in the session on login

// Fetch user data
$sql = "SELECT username, email FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Prepare user data for display
$userData = null;
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    $userData = ['username' => 'Not found', 'email' => 'Not found'];
}

// Close connection
$stmt->close();
$conn->close();
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
            position: relative;
            display: inline-block;
            margin-left: 20px;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            left: 0;
            top: 100%;
            background-color: #1C1C28;
            min-width: 160px;
            border-radius: 8px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            transform: translateY(10px);
        }
        .user-menu:hover .dropdown-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            transition: background-color 0.3s, color 0.3s;
        }
        .dropdown-content a:hover {
            background-color: #333;
            color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #1C1C28;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info p {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
        }
        .edit-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #808080;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .edit-button:hover {
            background-color: #555;
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
                    <a href="/Shoe Shop/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>User Profile</h2>
        <div class='profile-info'>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($userData['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
        </div>
        
        <!-- Edit Profile Button -->
        <a href="edit_profile.php" class="edit-button">Edit Profile</a>
    </div>
</body>
</html>