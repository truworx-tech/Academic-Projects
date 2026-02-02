<?php
session_start(); // Start session at the beginning

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute query
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['username'] = $user['username']; // Set username in session
        $_SESSION['user_id'] = $user['id']; // Set user ID in session
        
        // Redirect to client.php
        header("Location: client.php");
        exit(); // Ensure no further code is executed
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>
