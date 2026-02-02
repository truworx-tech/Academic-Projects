<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel</title>
    <link rel="stylesheet" href="Assets/css/customerpanel.css">
</head>
<body>
    <div class="gallery-container">
        <h1>Welcome to Your Gallery</h1>
        <div class="gallery">
            <?php
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'Client');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch the images from the database
            $sql = "SELECT * FROM customer_images LIMIT 15";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="image-box">';
                    echo '<img src="' . $row['image_url'] . '">';
                    /*echo '<h2>' . $row['title'] . '</h2>';*/
                    echo '</div>';
                }
            } else {
                echo "No images found.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
