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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // No hashing as per your requirement
    $role_id = $_POST['role_id']; // Now this will come from the dropdown

    $sql = "INSERT INTO Users (username, password, email, role_id, created_at) VALUES ('$username', '$password', '$email', '$role_id', NOW())";

    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch roles from the database
$roles_sql = "SELECT role_id, role_name FROM Roles"; // Adjust if your table structure differs
$roles_result = $conn->query($roles_sql);
$roles = [];
if ($roles_result->num_rows > 0) {
    while ($row = $roles_result->fetch_assoc()) {
        $roles[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Hinagiban</title>
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
            margin: 20px;
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
            margin-top: 20px;           /* Add some space above */
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
    <h1>Add New User</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="text" id="password" name="password" required>
        
        <label for="role_id">Role:</label>
        <select id="role_id" name="role_id" required>
            <option value="" disabled selected>Select a role</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo htmlspecialchars($role['role_id']); ?>">
                    <?php echo htmlspecialchars($role['role_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <input type="submit" value="Add User">
    </form>
    
    <div class="link-container">
        <a href="admin.php">Back to Admin Panel</a>
    </div>
</body>
</html>
