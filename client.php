<?php
session_start();

// Database connection code
$servername = "localhost";
$username = "root";
$password = "";
$database = "Client";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Fetch the user's name from the session
$username = $_SESSION['username']; // Fetch username from session

// Handle form submission
$notification_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_booking'])) {
    $full_name = $_POST['full_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_type = $_POST['event_type'];
    $mobile_number = $_POST['mobile_number'];
    $location = $_POST['location'];
    $additional_message = $_POST['additional_message'];
    $user_id = $_SESSION['user_id']; // Assume user ID is stored in session

    $sql = "INSERT INTO shoot_bookings (user_id, full_name, event_date, event_time, event_type, mobile_number, location, additional_message)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $user_id, $full_name, $event_date, $event_time, $event_type, $mobile_number, $location, $additional_message);
    if ($stmt->execute()) {
        $notification_message = "Your booking was successfully submitted. Our team will contact you soon.";
    } else {
        $notification_message = "Failed to submit the booking. Please try again.";
    }
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="Assets/css/stylesheetclient.css" />
    <title>Client Page</title>
    <style>
        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            max-width: 500px;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .popup-form.show {
            display: block;
        }
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .popup-overlay.show {
            display: block;
        }
        .popup-form .close-button {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }
        .popup-form form {
            display: flex;
            flex-direction: column;
        }
        .popup-form form input, .popup-form form select, .popup-form form textarea {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
        .notification {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            z-index: 1000;
        }
        .notification.show {
            display: block;
        }
    </style>
</head>
<body>
    <header class="header" id="home">
        <nav>
            <div class="nav__header">
                <div class="nav__logo">
                    <a href="adminlogin.html">
                        <img src="Assets/img/website-logo.png" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
            <div>
                <ul class="nav__links" id="nav-links">
                    <li class="nav__item"><a href="index.php" class="nav__link">BACK TO HOME</a></li>
                    <li class="nav__item"><a href="customergallary.php" class="nav__link">MY GALLERY</a></li>
                    <li class="nav__item"><a href="contact.html" class="nav__link">CONTACT</a></li>
                    <li class="nav__item"><a href="login.html" class="nav__link">LOG OUT</a></li>
                    <li class="nav__item username">Hi, <?php echo htmlspecialchars($username); ?>!</li> <!-- Display logged-in user's name -->
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="button-container">
            <button id="bookShootBtn" class="button button--book-shoot">Book New Shoot</button>
            <a href="customergallary.php"><button class="button button--my-gallery">My Gallery</button></a>
        </div>

        <!-- Popup Form -->
        <div id="popupOverlay" class="popup-overlay"></div>
        <div id="popupForm" class="popup-form">
            <div class="close-button" id="closePopup">&times;</div>
            <h2>Book a New Shoot</h2>
            <?php if (!empty($notification_message)): ?>
                <p><?php echo htmlspecialchars($notification_message); ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="date" name="event_date" required>
                <input type="time" name="event_time" required>
                <select name="event_type" required>
                    <option value="marriage">Marriage</option>
                    <option value="birthday">Birthday</option>
                    <option value="modelling">Modelling</option>
                    <option value="portraits">Portraits</option>
                    <option value="other">Other</option>
                </select>
                <input type="text" name="mobile_number" placeholder="Mobile Number" required>
                <input type="text" name="location" placeholder="Location of Event" required>
                <textarea name="additional_message" placeholder="Additional Message"></textarea>
                <input type="submit" name="submit_booking" value="Submit">
            </form>
        </div>
        
        <!-- Notification -->
        <?php if (!empty($notification_message)): ?>
            <div id="notification" class="notification show">
                <?php echo htmlspecialchars($notification_message); ?>
            </div>
        <?php else: ?>
            <div id="notification" class="notification"></div>
        <?php endif; ?>
    </main>

    <!-- Pricing List Section -->
    <section class="pricing-list">
        <h2>Our Pricing Packages</h2>
        <div class="pricing-container">
            <div class="pricing-box basic">
                <h3>Basic Package</h3>
                <p class="price">20,000</p>
                <ul class="details">
                    <li>1 Cameraman</li>
                    <li>No Outdoor Shoot</li>
                    <li>No Videography</li>
                    <li>No Signing Frame</li>
                    <li>No Album</li>
                </ul>
                <p class="delivery">Delivery: 30 to 60 days</p>
            </div>
            <div class="pricing-box silver">
                <h3>Silver Package</h3>
                <p class="price">40,000</p>
                <ul class="details">
                    <li>2 Cameramen</li>
                    <li>1 Videographer</li>
                    <li>No Signing Frame</li>
                    <li>No Album</li>
                </ul>
                <p class="delivery">Delivery: 30 to 40 days</p>
            </div>
            <div class="pricing-box gold">
                <h3>Gold Package</h3>
                <p class="price">60,000</p>
                <ul class="details">
                    <li>2 Photographers</li>
                    <li>2 Videographers</li>
                    <li>All Features Included</li>
                </ul>
                <p class="delivery">Delivery: 10 days</p>
            </div>
        </div>
    </section>

    <br>

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

    <script>
        document.getElementById('bookShootBtn').addEventListener('click', function() {
            document.getElementById('popupOverlay').classList.add('show');
            document.getElementById('popupForm').classList.add('show');
        });

        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('popupOverlay').classList.remove('show');
            document.getElementById('popupForm').classList.remove('show');
        });

        window.onload = function() {
            var notification = document.getElementById('notification');
            if (notification.classList.contains('show')) {
                setTimeout(function() {
                    notification.classList.remove('show');
                }, 5000); // Hide notification after 5 seconds
            }
        };
    </script>
    <script src="Assets/js/script.js"></script>
</body>
</html>
