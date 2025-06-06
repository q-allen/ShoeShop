<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hinagiban</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
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

        /* Styling for the image banner */
        .about-image-container {
            position: relative;
            width: 100%;
            max-height: 500px;
            overflow: hidden;
        }

        .about-image {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .overlay-text {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: white;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
            max-width: 100%; /* Ensure there's enough width for one line */
            white-space: nowrap; /* Prevent wrapping */
        }

        .overlay-text h1 {
            font-size: 58px; /* Keep larger font size */
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap; /* Force text to stay on one line */
        }

        .overlay-text p {
            font-size: 24px;
            margin: 0;
            font-weight: 300;
}

        main {
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px 20px;
        }

        /* Section Box Styling */
        .section-box {
            background-color: #2a2a2a;
            margin-bottom: 30px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: left;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 80px;
            font-family: 'Poppins', sans-serif; /* Apply Poppins font here */
        }

        .section-box h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #f5f5f5;
            font-weight: 600;
            font-family: 'Poppins', sans-serif; /* Apply Poppins font to h2 */
        }

        .section-box p {
            font-size: 14px;
            color: #f5f5f5;
            line-height: 1.8;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif; /* Apply Poppins font to p */
        }

        .section-box p strong {
            font-weight: bold;
            color: #f5f5f5;
        }

        .about-section {
            display: flex;
            flex-direction: row;
        }

        p strong {
            margin-top: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer {
            margin-top: 50px;
            padding: 20px 0;
            background-color: #121212;
            color: #f5f5f5;
            text-align: center;
            font-size: 16px;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .overlay-text h1 {
                font-size: 36px;
            }

            .overlay-text p {
                font-size: 18px;
            }

            .section-box h2 {
                font-size: 28px;
            }

            .section-box p {
                font-size: 16px;
            }
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
            <a href="#" style="margin-right: 20px;"><img src="/Shoe Shop/images/bag.png" alt="Cart" width="20"></a>
            <a href="#"><img src="/Shoe Shop/images/profile.png" alt="User" width="20"></a>
        </div>
    </header>
    <main>
        <!-- "Know Us More" and "About Us" Section -->
        <div class="text-header" style="text-align:left; margin: 20px 0;">
            <h1 style="color: grey; margin-bottom: 0;">know us more</h1>
            <h2 style="font-size: 40px; margin-top: -25px;">About Us</h2>
        </div>



        <!-- Image Banner with Text Overlay -->
        <div class="about-image-container">
            <img src="/Shoe Shop/images/about-img.png" alt="Helping you keep fit" class="about-image">
            <div class="overlay-text">
                <h1>Helping You Keep Fit</h1>
                <p>Since 2024</p>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="about-section">
            <div class="section-box">
                <h2>Who We Are</h2>
                <p>Hinagiban is your go-to destination for premium footwear. We specialize in a diverse range of shoes for both men and women, offering collections from top brands renowned for their innovative designs and exceptional durability.</p>
            </div>

            <div class="section-box">
                <h2>Our Philosophy</h2>
                <p>We understand that shoes are more than just an accessory—they're a crucial part of your lifestyle. Whether you're looking for athletic sneakers, elegant dress shoes, or casual everyday wear, our curated selection combines fashion and function.</p>
            </div>

            <div class="section-box">
                <h2>Sales and Support</h2>
                <p>Our commitment to excellence extends beyond design and production to sales and support services, ensuring a seamless shopping experience through a user-friendly website and knowledgeable customer support team.</p>
            </div>

            <div class="section-box">
                <h2>Join Us on Our Journey</h2>
                <p>As we continue to grow, we invite you to explore our collections and experience the Hinagiban difference. Whether you're hitting the gym, attending a special event, or enjoying a day out, we have the perfect shoes for every occasion.</p>
            </div>
        </div>
        <p><strong>Thank you for choosing Hinagiban. We look forward to helping you find your next favorite pair!</strong></p>
    </main>
     <?php include $_SERVER['DOCUMENT_ROOT'] . '/Shoe Shop/footer.php'; ?>
</body>
</html>
