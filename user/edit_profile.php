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

// Fetch user data for pre-filling the form
$sql = "SELECT username, email, password FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$userData = null;
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    die("User not found.");
}

// Update user data if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['password'];

    // Check if the old password matches the stored password
    if ($oldPassword === $userData['password']) {
        // Update query for username, email, and password
        $updateSql = "UPDATE Users SET username = ?, email = ?, password = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssi", $newUsername, $newEmail, $newPassword, $userId);
        
        if ($updateStmt->execute()) {
            $message = "Profile updated successfully.";
        } else {
            $message = "Error updating profile: " . $conn->error;
        }
        
        $updateStmt->close();
    } else {
        $message = "Old password is incorrect.";
    }
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
    <title>Edit Profile - Hinagiban</title>
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
            left: 0; /* Aligns the dropdown to the left of the icon */
            top: 100%; /* Positions it below the icon */
            background-color: #1C1C28; /* Dark background */
            min-width: 160px; /* Width of the dropdown */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3); /* Enhanced shadow */
            z-index: 1;
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
        }
        .dropdown-content a:hover {
            background-color: #333; /* Background change on hover */
            color: #fff; /* Ensure text remains white on hover */
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
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 8px;
            background-color: #333;
            color: #f5f5f5;
        }
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 8px;
            background-color: #333;
            color: #f5f5f5;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            color: blue;
            text-align: center;
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
        <h2>Edit Profile</h2>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form action="edit_profile.php" method="post">

            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Username" style="font-family: 'Poppins', sans-serif;" value="<?php echo htmlspecialchars($userData['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email" style="font-family: 'Poppins', sans-serif;" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

            <label for="old_password">Old Password:</label>
            <input type="password" style="font-family: 'Poppins', sans-serif;" id="old_password" name="old_password" required>

            <label for="password">New Password:</label>
            <input type="password" style="font-family: 'Poppins', sans-serif;" id="password" name="password" required>

            <input type="submit" value="Update Profile">
        </form>
    </div>
</body>
</html>
