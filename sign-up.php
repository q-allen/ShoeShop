<?php
// Initialize error message variable
$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fetching form inputs with validation
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;

    // Check for empty fields
    if (empty($username) || empty($password) || empty($confirm_password) || empty($email)) {
        $error_message = 'Please fill in all fields.';
    } 
    // Validate that passwords match
    else if ($password !== $confirm_password) {
        $error_message = 'Passwords do not match!';
    } 
    // Database connection
    else {
        $conn = new mysqli('localhost', 'root', '', 'shoe_shop');

        // Check for connection errors
        if ($conn->connect_error) {
            $error_message = 'Connection Failed: ' . $conn->connect_error;
        } else {
            // Check if username or email already exists
            $stmt = $conn->prepare("SELECT COUNT(*) FROM Users WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $error_message = 'Error: Username or email already exists. Please choose a different username or email.';
            } else {
                // Prepare the SQL statement with placeholders
                $stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");

                if ($stmt === false) {
                    $error_message = 'Error preparing the statement: ' . $conn->error;
                } else {
                    // Bind the parameters (username, email, plain-text password)
                    $stmt->bind_param("sss", $username, $email, $password);

                    // Execute the prepared statement and check for success
                    if ($stmt->execute()) {
                        // Redirect upon success
                        header("Location: /Shoe Shop/user/index.php");
                        exit();
                    } else {
                        // Handle SQL execution error
                        $error_message = "Error: " . $stmt->error;
                    }

                    // Close the statement
                    $stmt->close();
                }
            }
        }
        // Close the connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .signup-container {
            background: linear-gradient(135deg, #2a2a2a, #1c1c1c);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #f5f5f5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            background-color: #333;
            color: #f5f5f5;
            transition: border-color 0.3s ease;
        }

        .signup-btn {
            width: 100%;
            padding: 12px;
            background-color: #0078d4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .signup-btn:hover {
            background-color: #006bb5;
        }

        .error-message {
            color: red;
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid red;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: left; /* Align text to the left */
            font-size: 14px; /* Adjust font size */
        }

        p {
            font-size: 14px;
            color: #ddd;
            margin-bottom: 20px;
        }

        p a {
            color: #007bff;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Create an Account</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Username*</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email address*</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password*</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password*</label>
            <input type="password" id="confirm-password" name="confirm_password" required>

            <button type="submit" class="signup-btn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>
</body>
</html>
