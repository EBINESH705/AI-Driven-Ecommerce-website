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
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security

    // Insert data into the database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        header("Location: uesrlogin.php");
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    
    <style>
        /* Your existing CSS styles */
    </style>
</head>
<style>
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

        
        .link-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            border-radius: 25px;
            border: none;
            color: white;
            cursor: pointer;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .link-button:hover {
            background: linear-gradient(135deg, #4b0fcf, #1b5be4);
        }
    </style>
<body>
    <div class="main">
        <h1>Register</h1>
        <h3>Create a New Account</h3>
        
        <form method="POST" action="">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your Full Name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your Email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your Password" required>

            <div class="wrap">
                <button type="submit">Register</button>
            </div>
        </form>
        <p>Already have an account? <a href="userlogin.php" class="login-link">Login Here</a></p>
    </div>

    <script>
        function validateRegistration() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            
            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }
            
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            
            return true;
        }
    </script>
</body>

</html>