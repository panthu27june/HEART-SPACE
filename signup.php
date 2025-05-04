<?php
session_start();
$msg = '';

$host = 'localhost';
$db   = 'register';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        $username = $_POST['userName'] ?? '';
        $mobileno = $_POST['mobileNo'] ?? '';
        $password = $_POST['password'] ?? '';
        $user_type = $_POST['user_type'] ?? 'user';

        if (!empty($username) && !empty($mobileno) && !empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Check if user already exists
            $stmt = $pdo->prepare("SELECT * FROM signup WHERE mobileno = ?");
            $stmt->execute([$mobileno]);
            if ($stmt->rowCount() > 0) {
                $msg = "User already exists!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO signup (username, mobileno, password, user_type) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$username, $mobileno, $hashedPassword, $user_type])) {
                    header('Location: login.php');
                    exit();
                } else {
                    $msg = "Signup failed.";
                }
            }
        } else {
            $msg = "All fields are required!";
        }
    }

} catch (PDOException $e) {
    echo "Database Connection Failed: " . $e->getMessage();
}

// $passwordHash = password_hash($password, PASSWORD_DEFAULT);

// signup.php

// require_once 'config.php'; // Database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    
    header('Location: login.php');  // Redirect to login page after successful registration
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="https://i.ibb.co/Sw6myQGM/Screenshot-2025-04-28-105042.png">
    <title>Sign up</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    /* background: linear-gradient(135deg, #f5f5f5, #e0e0e0); */
    background: linear-gradient(to right, skyblue, #FFCCE1, #FFCCE1, skyblue);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

form {
    background-color: skyblue;
    /* padding: 40px; */
    padding: 40px 35px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

.account h1 {
    font-size: 28px;
    color: black;
    text-align: center;
}

.account h2 {
    font-size: 16px;
    color: #777;
    text-align: center;
    margin-bottom: 20px;
}

.form h2 {
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin-bottom: 10px;
    font-size: 14px;
}

input:focus {
    outline: none;
    border-color: #EE4B2B;
    box-shadow: 0 0 0 2px rgba(238, 75, 43, 0.2);
}

button {
    width: 35%;
    padding: 10px;
    background-color: black;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    cursor: pointer;
    /* transition: background-color 0.3s; */
    margin-top: 10px;
    text-align: center;
}

button:hover {
    background-color: #d13b22;
    color: white;
    text-decoration: underline;

    
}

.su p {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: #555;
}

.su a {
    text-decoration: none;
    color: black;    
    font-weight: bold;
}
.su a:hover{
    color: #ee4b2b;
    text-decoration: underline;

}
.msg {
    text-align: center;
    font-size: 14px;
    margin-bottom: 10px;
}
.ss {
    display: flex;
    justify-content: center;
}

.su {
    text-align: center;
    width: 100%;
}
    </style>     
</head>
<body>
    <form action="signup.php" method="POST">
        <div class="account">
            <div>
                <h1>Create Account</h1>
                <h2>Hey there, Signup and get Started.</h2>
            </div>
        </div>

        <div class="form">
            <!-- <div class="user">
                <select name="user_type" class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>           
            </div> -->

            <p class="msg" style="color:red;"><?php echo $msg; ?></p>

            <div class="un">
                <h2>User Name:-</h2>
                <input type="text" placeholder="Example:- malhar028" name="userName" required>
            </div>
            <br>
            <div class="m">
                <h2>Mobile No:-</h2>
                <input type="text" placeholder="Enter Your Mobile No:-" name="mobileNo" required>
            </div>
            <br>
            <div class="p">
                <h2>Password:-</h2>
                <input type="password" placeholder="Enter Your Password:-" name="password" required>
            </div>
        </div>

        <div class="ss">
            <div class="su">
                <button type="submit" name="register">Submit</button>

                
                <p>Already have an account?
                <!-- <button name="login"> -->
                <a href="login.php">Login</a>
                <!-- </button>  -->
                </p> 
            </div>
        </div>
    </form>
</body>
</html>
