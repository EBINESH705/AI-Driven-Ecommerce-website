<?php
session_start();
$connection = new mysqli('localhost', 'root', '', 'ecommerce');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle product addition
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    $query = "INSERT INTO products (name, price, image, description) VALUES ('$name', '$price', '$image', '$description')";
    $connection->query($query);
}

// Fetch products
$products = $connection->query("SELECT * FROM products");

// Fetch orders
$orders = $connection->query("SELECT * FROM orders");

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $connection->query("UPDATE orders SET status='$status' WHERE id='$order_id'");
    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Admin Panel</h2>
    
    <h3>Add Product</h3>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="price" placeholder="Price" required>
        <input type="file" name="image" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        <button type="submit" name="add_product">Add Product</button>
    </form>
    
    <h3>Product List</h3>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Description</th></tr>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>" width="50"></td>
                <td><?php echo $row['description']; ?></td>
            </tr>
        <?php } ?>
    </table>
    
    <h3>Orders</h3>
    <table border="1">
        <tr><th>Order ID</th><th>User ID</th><th>Total Amount</th><th>Status</th><th>Action</th></tr>
        <?php while ($row = $orders->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['status']; ?></td>
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
