<?php
session_start();
$connection = new mysqli('localhost', 'root', '', 'ecommerce');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$user_id = 1; // Placeholder (replace with actual logged-in user ID)

// Fetch cart items to calculate total
$cart_items = $connection->query("SELECT cart.product_id, products.price, cart.quantity 
                                  FROM cart 
                                  JOIN products ON cart.product_id = products.id 
                                  WHERE cart.user_id='$user_id'");

$total_amount = 0;

$order_items = [];
while ($row = $cart_items->fetch_assoc()) {
    $total_amount += $row['price'] * $row['quantity'];
    $order_items[] = $row;
}

// Handle Checkout
if (isset($_POST['place_order'])) {
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    
    // Insert into orders table
    $connection->query("INSERT INTO orders (user_id, total_amount, status) VALUES ('$user_id', '$total_amount', 'pending')");
    $order_id = $connection->insert_id;
    
    // Insert into order_items table
    foreach ($order_items as $item) {
        $connection->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                            VALUES ('$order_id', '{$item['product_id']}', '{$item['quantity']}', '{$item['price']}')");
    }
    
    // Clear cart
    $connection->query("DELETE FROM cart WHERE user_id='$user_id'");
    
    echo "<script>alert('Order Placed Successfully!'); window.location='user_panel.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Checkout</h2>
   
    <form method="post">
    <h2>Total Amount: <?php echo $total_amount; ?> </h2>
    
        <label>Address:</label>
        <textarea name="address" required></textarea>
        
        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="cod">Cash on Delivery</option>
            <option value="card">Credit/Debit Card</option>
        </select>
        
        <button type="submit" name="place_order">Place Order</button>
    </form>
</body>
</html>
