<!DOCTYPE html>
<html>

<head>
    <title>Login Selection</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main">
        <h1>Welcome</h1>
        <h3>Select Login Type</h3>
        
        <div class="selection">
            <button onclick="location.href='userlogin.php'">User Login</button>
            <button onclick="location.href='adminlogin.php'">Admin Login</button>
        </div>
    </div>

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Arial", sans-serif;
            min-height: 100vh;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            margin: 0;
        }

        .main {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: #2c3e50;
        }

        .selection button {
            background-color: #ff6b81;
            color: white;
            padding: 15px 20px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            font-size: 16px;
            margin: 10px;
        }

        .selection button:hover {
            background-color: #d63447;
        }
    </style>
</body>

</html>