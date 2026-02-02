<?php
// Database connection
$host = 'localhost';  // Database host
$dbname = 'System';   // Database name
$user = 'root';       // Database username (default for XAMPP)
$pass = '';           // Database password (default for XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialize success and error messages
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Basic validation
    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $query = "INSERT INTO messages (name, email, phone, message) VALUES (:name, :email, :phone, :message)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':message' => $message
            ]);
            
            $successMessage = 'Message sent successfully!';
        } catch (PDOException $e) {
            $errorMessage = 'Failed to send message: ' . $e->getMessage();
        }
    } else {
        $errorMessage = 'All required fields must be filled out!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <link rel="stylesheet" href="contact_form.css">
</head>
<body>
    <div class="message-container">
        <?php if (!empty($successMessage)): ?>
            <p class="success-message"><?php echo htmlspecialchars($successMessage); ?></p>
            <script>
                alert('<?php echo htmlspecialchars($successMessage); ?>');
            </script>
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
    </div>
    <a href="contact.html">Back to Contact Form</a>
</body>
</html>