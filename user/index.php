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
            position: relative; /* Necessary for dropdown positioning */
            display: inline-block; /* To allow the dropdown to position relative to the icon */
            margin-left: 20px; /* Space between user icon and the dropdown */
        }

        .dropdown-content {
            display: none; /* Hidden by default */
            position: absolute;
            right: 0; /* Aligns the dropdown to the right of the icon, so it opens to the left */
            top: 100%; /* Positions it below the icon */
            background-color: #1C1C28; /* Dark background */
            min-width: 190px; /* Width of the dropdown */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3); /* Enhanced shadow */
            z-index: 1000; /* Ensure it's on top */
            opacity: 0; /* Start with hidden opacity */
            transition: opacity 0.3s ease, transform 0.3s ease; /* Smooth transitions */
            transform: translateY(10px); /* Slightly move down */
            max-height: 200px; /* Max height for long dropdowns */
            overflow-y: auto; /* Enable scrolling if content exceeds max height */
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

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 80px);
            flex-direction: column;
            text-align: center;
        }
        .hero h2 {
            font-size: 48px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .hero p {
            font-size: 18px;
            font-weight: 400;
            margin-top: 0;
        }
        .hero img {
            width: 500px;
            max-width: 100%;
            margin: 20px 0;
        }

        /* Men's Basketball Shoes Section */
        .container {
            position: relative;
            text-align: left;
            width: 100vw;
            height: 90vh;
            overflow: hidden;
        }

        .container img.background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .content {
            padding-left: 50px;
            color: white;
            position: relative;
        }

        .content p {
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 10px;
        }

        .content h1 {
            font-size: 80px;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .price-and-button {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .price-tag {
            font-size: 32px;
            font-weight: 600;
            margin-right: 20px;
        }

        .buy-now {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #000;
            color: white;
            padding: 14px 24px;
            font-size: 18px;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .buy-now:hover {
            background-color: #333;
        }

        .buy-now .arrow {
            margin-left: 10px;
            font-size: 20px;
        }

        .shoe-image {
            position: absolute;
            left: 50%; /* Center horizontally */
            top: 50%; /* Center vertically */
            transform: translate(-50%, -50%) rotate(-30deg); /* Move 50% back horizontally and vertically, and rotate */
            width: 450px;
            max-width: 100%;
        }

        /* Women's Shoes Section */
        .shoe-grid {
            display: flex;
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
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
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
                    <a href="/Shoe Shop/user/purchased product.php">Purchased Product</a>
                    <a href="/Shoe Shop/logout.php" style= "color: red">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h2>AIR Beyond Compare</h2>
        <img src="/Shoe Shop/images/home.png" alt="Shoe Image">
        <p>Every Step Counts, Make Yours Comfortable</p>
    </section>

    <!-- Men's Basketball Shoes Section -->
    <div class="container">
        <img src="/Shoe Shop/images/men/men.png" class="background" alt="Background Image">

        <div class="content">
            <p>Men’s Shoes</p>
            <h1>GIANNIS FREAK 6</h1>
            <div class="price-and-button">
                <span class="price-tag">₱7,895</span>
                <a href="men.php" class="buy-now">
                    <span>Buy Now</span>
                    <span class="arrow">></span>
                </a>
            </div>
        </div>

        <img src="/Shoe Shop/images/men/m.png" alt="Shoe Image" class="shoe-image">
    </div>

    <!-- Women's Shoes Section -->
    <section class="women-shoes">
        <h1 style="text-align: left; margin-left: 10px; font-size: 32px">Women's Shoes</h1>
        <div class="shoe-grid">
            <!-- Shoe item 1 -->
            <div class="shoe-item">
                <img src="/Shoe Shop/images/women/w.png" width="200px" height="280px" alt="Nike Air Max Dn Premium">
                <h2>Nike Air Max Dn</h2>
                <p class="price">₱9,395</p>
                <button>Add to Bag</button>
            </div>

            <!-- Shoe item 2 -->
            <div class="shoe-item">
                <img src="/Shoe Shop/images/women/w2.png" alt="Nike Air Max Plus">
                <h2>Nike Air Max Plus</h2>
                <p class="price">₱9,895</p>
                <button>Add to Bag</button>
            </div>

            <!-- Shoe item 3 -->
            <div class="shoe-item">
                <img src="/Shoe Shop/images/women/w3.png" alt="Nike Air Force 1">
                <h2>Nike Air Force 1</h2>
                <p class="price">₱6,895</p>
                <button>Add to Bag</button>
            </div>
        </div>
    </section>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Shoe Shop/footer.php'; ?>
</body>
</html>
