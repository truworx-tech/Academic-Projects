<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Client";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_image'])) {
    $image_id = $_POST['image_id'];
    $image_url = $_POST['image_url'];
    $title = $_POST['title'];

    $sql = "UPDATE customer_images SET image_url=?, title=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $image_url, $title, $image_id);

    if ($stmt->execute()) {
        $update_message = "Image updated successfully";
    } else {
        $update_message = "Error updating image: " . $conn->error;
    }

    $stmt->close();
}

// Handle user creation form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password
    $phone = $_POST['phone'];

    $sql = "INSERT INTO users (username, email, password, phone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $password, $phone);

    if ($stmt->execute()) {
        $user_message = "User account created successfully";
    } else {
        $user_message = "Error creating user: " . $stmt->error;
    }

    $stmt->close();
}

// Handle delete order
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_order'])) {
    $order_id = $_GET['delete_order'];

    $sql = "DELETE FROM shoot_bookings WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $delete_message = "Order deleted successfully";
    } else {
        $delete_message = "Error deleting order: " . $stmt->error;
    }

    $stmt->close();
}

$orders = [];
$sql = "SELECT sb.id, u.username, sb.full_name, sb.event_date, sb.event_time, sb.event_type, sb.mobile_number, sb.location, sb.additional_message
        FROM shoot_bookings sb
        JOIN users u ON sb.user_id = u.id
        ORDER BY sb.created_at DESC";
$result = $conn->query($sql);

if ($result === false) {
    // Log the error message
    die("SQL error: " . $conn->error);
} elseif ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel for Customer</title>
    <link rel="stylesheet" href="Assets/css/customeradmin.css">
</head>
<body>
    <h1>Admin Panel for Customer</h1>

    <!-- Image Update Form -->
    <section>
        <h2>Update Image Details</h2>
        <form action="customeradmin.php" method="POST">
            <label for="image_id">Image ID:</label>
            <input type="number" id="image_id" name="image_id" required>
            
            <label for="image_url">Image URL:</label>
            <input type="text" id="image_url" name="image_url" required>
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            
            <button type="submit" name="update_image">Update Image</button>
        </form>
        <?php if (isset($update_message)) echo "<p>$update_message</p>"; ?>
    </section>

    <!-- User Creation Form -->
    <section>
        <h2>Create User Account</h2>
        <form action="customeradmin.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            
            <button type="submit" name="create_user">Create Account</button>
        </form>
        <?php if (isset($user_message)) echo "<p>$user_message</p>"; ?>
    </section>

    <!-- View Orders -->
    <section>
        <h2>View Orders</h2>
        <?php if (isset($delete_message)) echo "<p>$delete_message</p>"; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Event Date</th>
                    <th>Event Time</th>
                    <th>Event Type</th>
                    <th>Mobile Number</th>
                    <th>Location</th>
                    <th>Additional Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['username']); ?></td>
                    <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['event_date']); ?></td>
                    <td><?php echo htmlspecialchars($order['event_time']); ?></td>
                    <td><?php echo htmlspecialchars($order['event_type']); ?></td>
                    <td><?php echo htmlspecialchars($order['mobile_number']); ?></td>
                    <td><?php echo htmlspecialchars($order['location']); ?></td>
                    <td><?php echo htmlspecialchars($order['additional_message']); ?></td>
                    <td>
                        <a href="customeradmin.php?delete_order=<?php echo htmlspecialchars($order['id']); ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>
