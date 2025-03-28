<?php
session_start();
$connection = new mysqli('localhost', 'root', '', 'ecommerce');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle product addition
if (isset($_POST['add_product'])) {
    $name = $connection->real_escape_string($_POST['name']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $description = $connection->real_escape_string($_POST['description']);
    
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $connection->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $name, $price, $image, $description);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];

    if (!empty($order_id) && !empty($new_status)) {
        $stmt = $connection->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param("si", $new_status, $order_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch products
$products = $connection->query("SELECT * FROM products");

// Fetch orders
$orders = $connection->query("SELECT * FROM orders");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Manage Products</h2>
    <a href="admin.php">Back to Admin</a>
   
    <h3>Orders</h3>
    <table border="1">
        <tr><th>Order ID</th><th>User ID</th><th>Total Amount</th><th>Status</th><th>Update Status</th></tr>
        <?php while ($row = $orders->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                        <select name="status">
                            <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                            <option value="cancelled" <?php if ($row['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>