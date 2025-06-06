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
            display: none;
            background-color: #f44336;
            color: white;
            padding: 15px;
            position: fixed;
            top: 20px;
            right: 20px;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
    <script>
        function checkLoginAndAddToBag() {
            // Simulate checking if the user is logged in
            const isLoggedIn = false; // Change this to your actual login check

            if (!isLoggedIn) {
                // Display notification message
                const notification = document.querySelector('.notification');
                notification.style.display = 'block';
                notification.innerText = "You need to log in first before you can add to the bag.";
                
                // Redirect to login.php after a brief delay
                setTimeout(() => {
                    window.location.href = '/Shoe Shop/login.php';
                }, 3000); // Adjust delay time as needed
            } else {
                // Logic for adding the item to the bag can go here
                alert("Item added to bag!"); // Placeholder for actual add to bag functionality
            }
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
            <a href="#" style="margin-right: 20px;"><img src="/Shoe Shop/images/bag.png" alt="Cart" width="20"></a>
            <a href="#"><img src="/Shoe Shop/images/profile.png" alt="User" width="20"></a>
        </div>
    </header>

    <main>
        <div class="notification"></div> <!-- Notification Message -->
        <!-- Men's Shoes Section -->
        <section class="women-shoes">
            <h1 style="text-align: left; margin-left: 10px; font-size: 32px">Men's Shoes</h1>
            <div class="mshoe-grid">
                <!-- Shoe item 1 -->
                <div class="shoe-item">
                    <img src="/Shoe Shop/images/men/m.png" alt="Nike Air Max Dn Premium">
                    <h2>Giannis Freak 6</h2>
                    <p class="price">₱7,895</p>
                    <button onclick="checkLoginAndAddToBag()">Add to Bag</button>
                </div>

                <!-- Shoe item 2 -->
                <div class="shoe-item">
                    <img src="/Shoe Shop/images/men/m2.png" alt="Nike Air Max Plus">
                    <h2>Nike P-6000</h2>
                    <p class="price">₱6,195</p>
                    <button onclick="checkLoginAndAddToBag()">Add to Bag</button>
                </div>

                <!-- Shoe item 3 -->
                <div class="shoe-item">
                    <img src="/Shoe Shop/images/men/m3.png" alt="Nike Air Force 1">
                    <h2>Nike Impact 4</h2>
                    <p class="price">₱4,795</p>
                    <button onclick="checkLoginAndAddToBag()">Add to Bag</button>
                </div>
            </div>
        </section>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/Shoe Shop/footer.php'; ?>
    </main>
</body>
</html>
