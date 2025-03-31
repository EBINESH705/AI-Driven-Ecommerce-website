
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
    $target = "image/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $connection->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $name, $price, $image, $description);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch products
$products = $connection->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Manage Order</h2>
    <a href="manage_products.php">Manage Order Status</a>
    
    <h3>Add Product</h3>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="price" placeholder="Price" required>
        <input type="file" name="image" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        <button type="submit" name="add_product">Add Product</button>
    </form>
    
    <h2>Product List</h2>
    <table border="1">
        <tr><th>Product ID</th><th> Product Name</th><th>Price</th><th>Description</th></tr>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <!-- <td><img src="uploads/<?php echo $row['image']; ?>" width="50"></td> -->
                <td><?php echo $row['description']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
