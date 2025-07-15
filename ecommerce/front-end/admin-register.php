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

    // Check if the email already exists
    $checkEmail = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO admin (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! Redirecting to login page...');</script>";
            header("Location: adminlogin.php");
            exit();
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Registration</title>
</head>

<body>
    <div class="main">
        <h1>Admin Registration</h1>
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
        <p>Already registered? <a href="adminlogin.php" class="login-link">Login Here</a></p>
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

        .login-link {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #ff4757;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        // Client-side validation
        document.querySelector("form").onsubmit = function () {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            if (password.length < 3) {
                alert("Password must be at least 6 characters long.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        };
    </script>
</body>

</html>