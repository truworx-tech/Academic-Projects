<?php
// Database connection
$host = 'localhost';
$dbname = 'System';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch images from the database
$sql = "SELECT * FROM gallery_images";
$stmt = $pdo->query($sql);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="Assets/css/gallery.css" />
    <title>Gallery | Malcolm Lismore Photography</title>
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
                <h2 class="section__header">GALLERY</h2>>
                <?php
                // Categorize images
                $categories = ['Birthday Photography', 'Marriage Photography', 'Wildlife Photography', 'Coastal Birds Photography', 'Food Photography'];
                foreach ($categories as $category) {
                    echo "<div class='gallery__category'>";
                    echo "<h3>$category</h3>";
                    echo "<div class='gallery__grid'>";
                    
                    foreach ($images as $image) {
                        if ($image['category'] === $category) {
                            echo "<div class='gallery__item'>";
                            echo "<img src='" . htmlspecialchars($image['image']) . "' alt='" . htmlspecialchars($image['title']) . "'>";
                            echo "<div class='gallery__details'>";
                            echo "<h4>" . htmlspecialchars($image['title']) . "</h4>";
                            echo "<p>$" . htmlspecialchars($image['price']) . "</p>";
                            echo "<p>Details about the " . htmlspecialchars($image['category']) . ".</p>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    
                    echo "</div>";
                    echo "</div>";
                }
                ?>
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

    <script src="Assets/js/script.js"></script>
</body>
</html>
