<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username if different
$password = ""; // Replace with your DB password if set
$dbname = "System";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if (isset($_POST['delete_gallery'])) {
    $id = $_POST['id']; // Get the image id to delete

    // Prepare and execute the delete query with correct SQL syntax
    $sql = "DELETE FROM gallery_images WHERE id=$id"; 

    $sql = "DELETE FROM home_images WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Image deleted successfully";
    } else {
        echo "Error deleting image: " . $conn->error;
    }

    // Close the connection
    $conn->close();

    // Redirect back to the admin page after deletion
    header("Location: admin.php");
    exit;
}
?>
