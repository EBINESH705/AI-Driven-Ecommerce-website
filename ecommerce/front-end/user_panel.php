<?php
session_start();
$connection = new mysqli('localhost', 'root', '', 'ecommerce');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch products
$products = $connection->query("SELECT * FROM products");

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $user_id = 1; // Placeholder (replace with actual logged-in user ID)
    
    $check_cart = $connection->query("SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
    if ($check_cart->num_rows > 0) {
        $connection->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'");
    } else {
        $connection->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)");
    }
    
    header("Location: user_panel.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Available Products</h2>
    <table border="1">
        <tr><th>Name</th><th>Price</th><th>Image</th><th>Action</th></tr>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><img src="image/<?php echo $row['image']; ?>" width="50"></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="cart.php">View Cart</a>
</body>
</html>
