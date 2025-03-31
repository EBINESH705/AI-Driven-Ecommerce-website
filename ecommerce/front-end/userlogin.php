<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Redirect to home.php
            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email. Please register first.');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
   
</head>

<body>
    <div class="main">
        <h1>Welcome</h1>
        <h3>User Login</h3>
        
        <div id="User" class="tabcontent">
            <form method="POST" action="">
                <label for="user-email">Email:</label>
                <input type="email" id="user-email" name="email" placeholder="Enter your Email" required>

                <label for="user-password">Password:</label>
                <input type="password" id="user-password" name="password" placeholder="Enter your Password" required>

                <a href="#" class="forgot-password">Forgot Password?</a>

                <div class="wrap">
                    <button type="submit">Submit</button>
                </div>
            </form>
            <p>Not registered? <a href="registraction.php" class="register-link">Register New Account</a></p>
        </div>
    </div>

    <style>
/* General Styles */
body {
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Arial", sans-serif;
    line-height: 1.5;
    min-height: 100vh;
    background: linear-gradient(to right, #ff7e5f, #feb47b);
    flex-direction: column;
    margin: 0;
}

.main {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
    padding: 30px;
    width: 400px;
    text-align: center;
}

h1 {
    color: #2c3e50;
}

label {
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
    text-align: left;
    color: #34495e;
    font-weight: bold;
}

input {
    display: block;
    width: 100%;
    margin-bottom: 15px;
    padding: 12px;
    box-sizing: border-box;
    border: 1px solid #bdc3c7;
    border-radius: 5px;
    background: #ecf0f1;
}

button {
    padding: 15px;
    border-radius: 10px;
    margin-top: 15px;
    border: none;
    color: white;
    cursor: pointer;
    background: #ff6b81;
    width: 100%;
    font-size: 16px;
    transition: background 0.3s ease;
}

button:hover {
    background: #d63447;
}

.wrap {
    display: flex;
    justify-content: center;
    align-items: center;
}

.forgot-password {
    display: block;
    text-align: right;
    margin-bottom: 10px;
    color: #ff4757;
    text-decoration: none;
}

.forgot-password:hover {
    text-decoration: underline;
}

.register-link {
    display: block;
    margin-top: 10px;
    font-size: 14px;
    color: #ff4757;
    text-decoration: none;
}

.register-link:hover {
    text-decoration: underline;
}
    </style>

    <script>
        function validateForm() {
            var email = document.getElementById("user-email").value;
            var password = document.getElementById("user-password").value;
            
            if (!email.includes("@")) {
                alert("Please enter a valid email address.");
                return false;
            }
            
            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }
            
            alert("User login successful!");
            return true;
        }
    </script>
</body> 

</html>
