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
    <title>E-Commerce</title>
    <link rel="stylesheet" href="stylse2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <a href="#" class="logo"><i class="fa fa-shopping-bag"></i>E-Commerce</a>
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
<div >
    <section class="menu" id="menu" >
        <h2 class="product" style="text-align: center;
    font-size: xx-large;
}">Available Products</h2>
        <div class="box-container">
            <?php while ($row = $products->fetch_assoc()) { ?>
                <div class="box">

                    <img src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"style="width: 200px; height: 200px; object-fit: cover;">
                    <h3><?php echo $row['name']; ?></h3>
                    <h3><?php echo $row['description']; ?></h3>
                    <span>$<?php echo $row['price']; ?></span>
                    <form class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="button" class="btn add-to-cart">Add to Cart</button>
                    </form>
   
                </div>
            <?php } ?>
        </div>
    </section>
    </div>

   
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
                <a href="#">9095934950</a>
                <a href="#">9095934950</a>
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');
:root {
    --green: #27ae60;
    --black: #192a56;
    --light-colour: #666;
    --box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);
}
* {
    font-family: 'nunito', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
    outline: none;
    border: none;
    text-transform: capitalize;
    transition: all .2s linear;
}
html {
    font-size: 63%;
    overflow: auto;
    scroll-padding-top: 5.5rem;
    scroll-behavior: smooth;
}
section.menu#menu {
    padding-top: 90px;
    padding: 2rem 9%;
    margin-top: 50px;
}
.sub-heading {
    font-size: 2.5rem;
    text-align: center;
    color: var(--green);
    font-weight: bolder;
    padding-top: 1rem;
}
.heading {
    font-size: 3rem;
    text-align: center;
    color: var(--black);
    font-weight: bolder;
    text-transform: uppercase;
    padding-top: 1rem;
}
.btn {
    background: var(--black);
    margin-top: 1rem;
    display: inline-block;
    font-size: 1.7rem;
    color: #fff;
    border-radius: .5rem;
    cursor: pointer;
    padding: .8rem 3rem;
}
.btn:hover {
    color: #fff;
    letter-spacing: .2rem;
    background: var(--green);
}
header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    padding: 1rem 7%;
    align-items: center;
    background: #fff;
    justify-content: space-between;
    box-shadow: var(--box-shadow);
}
header .logo {
    font-size: 2.5rem;
    font-weight: bolder;
    color: var(--black);
}
header .logo i {
    color: var(--green);
}
header .navbar a {
    font-size: 1.7rem;
    border-radius: .5rem;
    padding: .5rem 1.5rem;
    color: var(--light-colour);
}
header .navbar a.active,
header .navbar a:hover {
    color: #fff;
    background: var(--green);
}
header .icons i,
header .icons a {
    cursor: pointer;
    margin-left: .5rem;
    height: 4.5rem;
    line-height: 4.5rem;
    width: 4.5rem;
    text-align: center;
    font-size: 1.7rem;
    color: var(--black);
    border-radius: 50%;
    background: #eee;
}
header .icons i:hover,
header .icons a:hover {
    background: var(--green);
    color: #fff;
    transform: rotate(360deg);
}
header .icons #menu-bar {
    display: none;
}
.home .home-slider .slide {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
    padding-top: 9rem;
}
.swiper {
    width: 100%;
    height: 100%;
}
.home .home-slider .slide .content,
.home .home-slider .slide .image {
    flex: 1 1 45rem;
}
.home .home-slider .slide .image img {
    width: 100%;
}
.home .home-slider .slide .content span {
    color: var(--green);
    font-size: 2.5rem;
    font-weight: bolder;
}
.home .home-slider .slide .content h3 {
    color: var(--black);
    font-size: 7rem;
}
.home .home-slider .slide .content p {
    color: var(--light-colour);
    font-size: 2.5rem;
    padding: .5rem 0;
    line-height: 1.5;
}
.swiper-pagination-bullet-active {
    background: var(--green);
}
.dishes .box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(40rem, 1fr));
    gap: 2.5rem;
}
.dishes .box {
    background: #fff;
    padding: 3rem;
    box-shadow: var(--box-shadow);
    border-radius: .5rem;
    overflow: hidden;
    position: relative;
    text-align: center;
}
h2.product {
    text-align: center;
    font-size: xxx-large;
}
.dishes .box-container .box .fa-heart,
.dishes .box-container .box .fa-eye {
    position: absolute;
    top: 1.5rem;
    background: #eee;
    border-radius: 50%;
    height: 5rem;
    width: 5rem;
    line-height: 5rem;
    font-size: 2rem;
    color: var(--black);
}
.dishes .box-container .box .fa-heart:hover,
.dishes .box-container .box .fa-eye:hover {
    background: var(--green);
    color: #fff;
}
.dishes .box-container .box .fa-heart {
    right: -15rem;
}
.dishes .box-container .box .fa-eye {
    left: -15rem;
}

.dishes .box-container .box:hover .fa-heart {
    right: 1.5rem;
}
.dishes .box-container .box:hover .fa-eye {
    left: 1.5rem;
}

.dishes .box img {
    width: 100%;
    border-radius: .5rem;
}
.dishes .box h3 {
    font-size: 2rem;
    color: var(--black);
    padding: 1rem 0;
}
.dishes .box .stars {
    padding: .5rem 0;
}
.dishes .box .stars i {
    font-size: 1.5rem;
    color: var(--green);
}
.dishes .box span {
    font-size: 2rem;
    color: var(--black);
}
.dishes .box .btn {
    margin-top: 1rem;
}
.about .row{
    display: flex;
    flex-wrap: wrap;
    gap:1.5rem;
    align-items: center;

}
.about .row .image{
    flex: 1 1  45rem;
}
.about .row .content{
    flex: 1 1  45rem;
}

.about .row .image img{
    width:100%;
}

.about .row .content h3{
    color: var(--black);
    font-size:4rem;
    padding: .5rem 0; 
}

.about .row .content p{
    color: var(--light-colour);
    font-size:1.5rem;
    padding: .5rem 0;
    line-height: 1.5; 
}

.about .row .content .icons-container{
    display: flex;
    gap:1rem;
    flex-wrap:wrap;
    padding: 1rem 0;
    margin-top: .5re;
}

.about .row .content .icons-container .icons{
    background: #eee;
    border-radius: 1.5rem;
    border:1rem solid rgba(0, 0, 0, .2);
    display: flex;
    align-items: center;
    justify-content: center;
    gap:1rem;
    flex:1 1 17rem;
    padding: 1.5 1rem;
}

.about .row .content .icons-container .icons{
    font-size: 2.5rem;
    color:var(--green);
}

.about .row .content .icons-container .icons span{
    font-size: 2.5rem;
    color:var(--black);
}

.menu .box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
    gap: 2.5rem;
}
.menu .box-container .box{
    background: #fff;
    border: .1rem solid rgba(0, 0, 0, .2);
    box-shadow: var(--box-shadow);
    border-radius: .5rem;
    text-align: center;
    padding-top: 10px;
   
}
.menu .box-container .box .image{
    height: 25rem;
    width:100%;
    padding: 1.5rem;
    overflow: hidden;
    position: relative;
}

.menu .box-container .box .image img{
    width: 100%;
    height: 100%;
    border-radius: .5rem;
    object-fit: cover;
}

.menu .box-container .box .image .fa-heart{
    position: absolute;
    top: 2rem;
    right:1.6rem;
    background: #eee;
    border-radius: 50%;
    height: 5rem;
    text-align: center;
    width: 5rem;
    line-height: 5rem;
    font-size: 2rem;
    color: var(--black);
}       

.menu .box-container .box .image .fa-heart:hover{
    background: var(--green);
    color: #fff;
}
.menu .box-container .box .content{
    padding: 1.5rem;
    text-align: center;
    padding-top: 0;
}
.menu .box-container .box .content .stars{
    padding: .5rem 0;
    font-size: 2rem;
    color:var(--green);
}

.menu .box-container .box .content h3{
    font-size: 2.5rem;
    color:var(--black);
}

.menu .box-container .box .content p{
    font-size: 1.5rem;
    color:var(--light-colour);
    padding: .5rem 0;
    line-height: 1.5;
}
.menu{
    padding: 2rem 9%;
    padding-top: 90px;
}
.menu .box-container .box .content .price{
    font-size: 2.5rem;
    font-weight: bolder;
    color:var(--green);
    padding: .5rem 0;
}


.footer .box-container{
 
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(25rem,1fr));
    gap:1.5rem;
}

.footer .box-container .box h3{
    padding: .5rem 0;
    font-size: 2.5rem;
    color: var(--black);
}
.footer .box-container .box a{
    display: block;
    padding: .5rem 0;
    font-size: 1.5rem;
    color: var(--light-colour);
}

.footer .box-container .box a:hover{
    color: var(--green);
    text-decoration:underline;
}

.footer .credit{
    text-align: center;
    border-top: .1rem solid rgba(0, 0, 0, .1);
    font-size: 2rem;
    color: var(--black);
    padding: .5rem;
    padding-top: .2rem;
    margin-top:1.5rem;;
}

























@media (max-width: 450px) {
    html {
        font-size: 50%;
    }
    header {
        padding: 1rem 2rem;
    }
    section {
        padding-top: 90px;
        padding: 2rem;
    }
    .dishes .box-container .box img{
        height: auto;
        width: 100%;
    }
    .order form .inputBox .input{
        width: 100%;
    }
}
@media (max-width: 768px) {
    header .icons #menu-bar {
        display: inline-block;
    }
    header .navbar {
        position: absolute;
        top: 100%;
        right: 0;
        left: 0;
        background: #fff;
        border-top: .1rem solid rgba(0, 0, 0, .2);
        border-bottom: .1rem solid rgba(0, 0, 0, .2);
        padding: 1rem;
        clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
    }
    header .navbar.active {
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    }
    header .navbar a {
        display: block;
        padding: 1.5rem;
        margin: 1rem 0;
        font-size: 2rem;
        background: #eee;
    }
    .home .home-slider .slide .content h3 {
        font-size: 5rem;
    }
}
@media (max-width: 991px) {
    html {
        font-size: 50%;
    }
    .dishes .box-container {
        display: grid;
       
    }
    .order form .inputBox .input{
        width: 100%;
    }
}
        </style>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>
