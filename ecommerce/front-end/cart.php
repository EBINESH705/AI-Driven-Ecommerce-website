<?php
session_start();
$connection = new mysqli('localhost', 'root', '', 'ecommerce');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$user_id = 1; // Placeholder (replace with actual logged-in user ID)

// Fetch cart items
$cart_items = $connection->query("SELECT cart.id, products.name, products.price, cart.quantity 
                                  FROM cart 
                                  JOIN products ON cart.product_id = products.id 
                                  WHERE cart.user_id='$user_id'");

// Handle Remove from Cart
if (isset($_POST['remove_item'])) {
    $cart_id = $_POST['cart_id'];
    $connection->query("DELETE FROM cart WHERE id='$cart_id'");
    header("Location: cart.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Your Cart</h2>
    <table border="1">
        <tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total Price</th><th>Action</th></tr>
        <?php while ($row = $cart_items->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['price'] * $row['quantity']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="remove_item">Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
