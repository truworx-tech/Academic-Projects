<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// index.php
include('admin/db_connect.php');

// Fetch images for the home page
$home_images_query = "SELECT * FROM home_images";
$home_images_result = $conn->query($home_images_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="Assets/css/stylesheet.css" />
    <title>Malcolm Lismore | Photography</title>
</head>
<body>
    <header class="header" id="home">
        <nav>
            <div class="nav__header">
                <div class="nav__logo">
                    <a href="#">
                        <img src="Assets/img/website-logo.png" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
            <div>
                <ul class="nav__links" id="nav-links">
                    <li class="nav__item"><a href="index.php" class="nav__link active-link">HOME</a></li>
                    <li class="nav__item"><a href="about.html" class="nav__link">ABOUT</a></li>
                    <li class="nav__item"><a href="gallery.php" class="nav__link">GALLERY</a></li>
                    <li class="nav__logo">
                        <a href="#">
                            <img src="Assets/img/website-logo.png" alt="logo" />
                        </a>
                    </li>
                    <li class="nav__item"><a href="contact.html" class="nav__link">CONTACT</a></li>
                    <li class="nav__item"><a href="login.html" class="nav__link">LOGIN</a></li>
                    <li class="nav__item"><a href="Register.html" class="nav__link">REGISTER</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="gallery">
            <div class="section__container">
                <h2 class="section__header">GALLERY PREVIEW</h2>
                <div class="gallery__grid">
                    <?php while ($row = $home_images_result->fetch_assoc()): ?>
                    <div class="gallery__item">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="gallery__details">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p><?php echo htmlspecialchars($row['price']); ?></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <section class="contact">
            <div class="section__container">
                <h2 class="section__header">CONTACT US</h2>
                <form action="message_box.php" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone">

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>

                    <input type="submit" value="Send Message">
                </form>
            </div>
        </section>
    </main>

    <footer id="contact">
        <div class="section__container footer__container">
            <div class="footer__col">
                <img src="Assets/img/website-logo.png" alt="logo" />
                <div class="footer__socials">
                    <a href="#"><i class="ri-facebook-fill"></i></a>
                    <a href="#"><i class="ri-instagram-line"></i></a>
                    <a href="#"><i class="ri-twitter-fill"></i></a>
                    <a href="#"><i class="ri-youtube-fill"></i></a>
                    <a href="#"><i class="ri-pinterest-line"></i></a>
                </div>
            </div>
            <div class="footer__col">
                <ul class="footer__links">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                    <li><a href="gallery.php">GALLERY</a></li>
                    <li><a href="login.html">CLIENT</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                    <li><a href="adminlogin.html">ADMIN</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contact Details</h4>
                <p>Email: <a href="mailto:fattuabz@gmail.com">malcolmlismore@gmail.com</a></p>
                <p>Phone: <a href="tel:+94721362773">+44 1234 567890</a></p>
                <p>Address: 123 Photography Lane, North West Coast, Scotland</p>
            </div>

            <div class="footer__col">
                <h4>STAY IN TOUCH</h4>
                <p>
                    Keep up-to-date with all things Capturer! Join our community and
                    never miss a moment!
                </p>
            </div>
        </div>
        <div class="footer__bar">
            Copyright © 2024 Malcolm Lismore Photography. All rights reserved.
        </div>
    </footer>
--------
    <script src="Assets/js/script.js"></script>
</body>
</html>
