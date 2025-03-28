<?php
session_start();
$connection = new mysqli('localhost', 'root', '', 'ecommerce');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch products
$products = $connection->query("SELECT * FROM products");

// Handle Add to Cart via AJAX
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
    
    $check_cart = $connection->query("SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
    if ($check_cart->num_rows > 0) {
        $connection->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'");
    } else {
        $connection->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)");
    }
    echo "success";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Food E-Commerce</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <a href="#" class="logo"><i class="fas fa-utensils"></i>FoodShop</a>
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#menu">Menu</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
        </nav>
        <div class="icons">
            <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </header>

    <section class="menu" id="menu">
        <h2>Available Products</h2>
        <div class="box-container">
            <?php while ($row = $products->fetch_assoc()) { ?>
                <div class="box">
                    <img src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"style="width: 200px; height: 200px; object-fit: cover;">
                    <h3><?php echo $row['name']; ?></h3>
                    <span>$<?php echo $row['price']; ?></span>
                    <form class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="button" class="btn add-to-cart">Add to Cart</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>Locations</h3>
                <a href="#">Chennai</a>
                <a href="#">Delhi</a>
                <a href="#">Mumbai</a>
                <a href="#">Kolkata</a>
                <a href="#">Patna</a>
            </div>

            <div class="box">
                <h3>Quick Links</h3>
                <a href="#">Home</a>
                <a href="#">Dishes</a>
                <a href="#">About</a>
                <a href="#">Menu</a>
                <a href="#">Order</a>
            </div>

            <div class="box">
                <h3>Contact Info</h3>
                <a href="#">9999999999</a>
                <a href="#">9999999999</a>
                <a href="#">abc@gmail.com</a>
                <a href="#">chennai, india-636 000</a>
            </div>

            <div class="box">
                <h3>Follow Us</h3>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
                <a href="#">LinkedIn</a>
            </div>
        </div>
        <div class="credit">Copyright @ 2025</div>
    </section>

    <script>
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                var product_id = $(this).closest('.add-to-cart-form').find('input[name="product_id"]').val();
                $.post("user_panel.php", { add_to_cart: true, product_id: product_id }, function(response){
                    if(response === "success"){
                        alert("Item added to cart successfully!");
                    }
                });
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>
