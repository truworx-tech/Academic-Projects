<?php
// admin.php

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

// Update Gallery Images
if (isset($_POST['update_gallery'])) {
    $id = $_POST['id'];
    $image = $_POST['image'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $sql = "UPDATE gallery_images SET image='$image', title='$title', price='$price', category='$category' WHERE id=$id";
    $conn->query($sql);
}

// Update Home Images
if (isset($_POST['update_home'])) {
    $id = $_POST['id'];
    $image = $_POST['image'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $sql = "UPDATE home_images SET image='$image', title='$title', price='$price' WHERE id=$id";
    $conn->query($sql);
}

// Mark message as read
if (isset($_GET['mark_read'])) {
    $id = $_GET['mark_read'];
    $sql = "UPDATE messages SET status='read' WHERE id=$id";
    $conn->query($sql);
}

// Fetch data for display
$galleryImages = $conn->query("SELECT * FROM gallery_images");
$homeImages = $conn->query("SELECT * FROM home_images");
$messages = $conn->query("SELECT * FROM messages ORDER BY status, id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
        h2 { background-color: #f2f2f2; padding: 10px; }
        form { margin-bottom: 20px; }

        /* Reset some default browser styles */
body, h1, h2, table, th, td, form {
    margin: 0;
    padding: 0;
    border: 0;
    box-sizing: border-box;
}

/* General styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}

/* Main header */
h1 {
    font-size: 2.5em;
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

/* Section headers */
h2 {
    font-size: 1.5em;
    color: #007bff;
    background-color: #e9ecef;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #e9ecef;
}

/* Form styles */
form {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

input[type="text"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Message status */
td.status-unread {
    background-color: #f99;
}

td.status-read {
    background-color: #9f9;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>

    <h1>Admin Panel</h1>

    <!-- Gallery Images Section -->
    <h2>MANAGE GALLERY IMAGES AND PRICING </h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Image URL</th>
            <th>Title</th>
            <th>Price</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $galleryImages->fetch_assoc()) { ?>
            <tr>
                <form method="post" action="admin.php">
                    <td><?php echo $row['id']; ?></td>
                    <td><input type="text" name="image" value="<?php echo $row['image']; ?>"></td>
                    <td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td>
                    <td><input type="text" name="price" value="<?php echo $row['price']; ?>"></td>
                    <td><input type="text" name="category" value="<?php echo $row['category']; ?>"></td>
                    <td>
                        <!-- Update Form -->
                         <form method="post" action="admin.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="update_gallery" value="Update" onclick="return confirmUpdate();">
                        </form>

                        <!-- Delete Form -->
                        <form method="post" action="delete.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete_gallery" value="Delete" onclick="return confirmDelete();" >
                        </form>
                    </td>
            </tr>
        <?php } ?>
    </table>

    <script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this gallery image?")) {
            alert("Deleted successfully.");
            return true; // Proceed with deletion
        }
        return false; // Cancel deletion
    }

    function confirmUpdate() {
        if (confirm("Are you sure you want to update this gallery image?")) {
            alert("Updated successfully.");
            return true; // Proceed with update
        }
        return false; // Cancel update
    }
</script>

    <!-- Home Images Section -->
    <h2>MANAGE HOME IMAGES</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Image URL</th>
            <th>Title</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $homeImages->fetch_assoc()) { ?>
            <tr>
                <form method="post" action="admin.php">
                    <td><?php echo $row['id']; ?></td>
                    <td><input type="text" name="image" value="<?php echo $row['image']; ?>"></td>
                    <td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td>
                    <td><input type="text" name="price" value="<?php echo $row['price']; ?>"></td>
                    <td>
                        <!-- Update Form -->
                         <form method="post" action="admin.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="update_home" value="Update" onclick="return confirmUpdate();">
                        </form>

                        <!-- Delete Form -->
                        <form method="post" action="delete.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete_home" value="Delete" onclick="return confirmDelete();" >
                        </form>
                    </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Messages Section -->
    <h2>VIEW MESSAGES</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $messages->fetch_assoc()) { ?>
            <tr style="background-color: <?php echo $row['status'] == 'unread' ? '#f99' : '#9f9'; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] == 'unread') { ?>
                        <a href="admin.php?mark_read=<?php echo $row['id']; ?>">Mark as Read</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
