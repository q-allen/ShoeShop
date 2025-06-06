<?php
session_start();

$error_message = ''; // Initialize the error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'shoe_shop');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Prepare the statement to retrieve user_id, password, and role_id
        $stmt = $conn->prepare("SELECT user_id, password, role_id FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $stored_password, $role_id); // Bind user_id, stored_password, and role_id
            $stmt->fetch();

            // Compare the plaintext password directly
            if ($password === $stored_password) {
                // Store session data
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role_id'] = $role_id;

                // Redirect based on role_id
                if ($role_id == 1) { // Assuming 1 is the admin role_id
                    header("Location: /Shoe%20Shop/admin/admin.php");
                } else {
                    header("Location: /Shoe%20Shop/user/index.php");
                }
                exit(); // Make sure to exit after redirecting
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "Invalid email or password."; // For non-existing email
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #0A0A18;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
        }

        .login-container {
            background: linear-gradient(135deg, #2a2a2a, #1c1c1c); /* Gradient background for aesthetics */
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* Softer shadow for depth */
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #f5f5f5; /* Light text for the heading */
            font-size: 1.8em; /* Slightly larger font size for the title */
        }

        .error-message {
            color: #ff4d4d; /* Brighter red for better visibility */
            margin-bottom: 1rem;
            font-size: 0.9em; /* Smaller font size for error message */
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px; /* Increased padding for a more spacious feel */
            margin: 0.5rem 0;
            border: 1px solid #555; /* Darker border to match the theme */
            border-radius: 8px; /* More rounded corners */
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            background-color: #333; /* Dark background for input fields */
            color: #f5f5f5; /* Light text for input fields */
            transition: border-color 0.3s ease; /* Smooth transition for border color */
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #bbb; /* Placeholder color */
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #28a745; /* Highlight border color on focus */
            outline: none; /* Remove default outline */
        }

        input[type="submit"] {
            width: 108%; /* Corrected width */
            background-color: #28a745; /* Green button */
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px; /* More rounded corners */
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease; /* Smooth transition for hover effect */
            margin-top: 1rem; /* Margin to separate from inputs */
        }

        input[type="submit"]:hover {
            background-color: #218838; /* Darker green on hover */
        }

        p {
            margin-top: 1.5rem;
            color: #ddd; /* Slightly lighter color for better readability */
        }

        a {
            color: #007bff; /* Link color */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        
        <form action="login.php" method="post">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <p>Don't have an account? <a href="sign-up.php">Sign up</a>.</p>
    </div>
</body>
</html>
