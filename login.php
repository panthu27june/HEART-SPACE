<?php
session_start();

// Database connection
$host = 'localhost';
$db   = 'register';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM signup WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: index.html");
                exit();
            } else {
                echo "<script>alert('Incorrect password');</script>";
            }
        } else {
            echo "<script>alert('User not found');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields');</script>";
    }
}

?>





<!-- <form action="login.php" method="POST">
    <input type="text" name="username" required>
    <input type="password" name="password" required>
    <button type="submit" name="login">Login</button>
</form> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="https://i.ibb.co/Sw6myQGM/Screenshot-2025-04-28-105042.png">
    <title>Login</title>
     <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body {
    /* background: linear-gradient(to right, #fff, #fcecec); */
    background: linear-gradient(to right, skyblue, #FFCCE1, #FFCCE1, skyblue);

    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

form {
    background-color: skyblue;
    padding: 40px 35px;
    border-radius: 16px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-25px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.account h1 {
    font-size: 2.5rem;
    color: #EE4B2B;
    color: black;
    text-align: center;
    margin-bottom: 10px;
}

.account h2 {
    font-size: 1rem;
    color: #666;
    text-align: center;
    margin-bottom: 30px;
}

.form {
    margin-top: 10px;
}

.form h2 {
    font-size: 1rem;
    margin-bottom: 6px;
    color: #444;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    outline: none;
    transition: border 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #EE4B2B;
}

.ss {
    text-align: center;
    margin-top: 30px;
}

.su button {
    background-color: black;
    color: #fff;
    border: none;
    padding: 12px 25px;
    font-size: 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.su button:hover {
    background-color: #ee4b2b;
    text-decoration: underline;
    /* color: white; */
}

.su p {
    margin-top: 15px;
    color: #333;
    font-size: 0.95rem;
}

.su a {
    color: black;
    text-decoration: none;
    font-weight: bold;
}

.su a:hover {
    color: #ee4b2b;
    text-decoration: underline;
}

/* Mobile Responsive */
@media (max-width: 500px) {
    form {
        padding: 25px 20px;
    }

    .account h1 {
        font-size: 2rem;
    }
}
     </style>
</head>
<body> 
    <form action="login.php" method="Post">
    <div class="account">
        <div>
            <h1>
                Login
            </h1>
            <h2>
                Welcome back, Please enter your details.
            </h2>
        </div>
    </div>

    <div class="form">
        <div class="un">
            <h2>User Name:-</h2>

            <input type="text" name="username" placeholder="Example:- malhar028">
        </div>
        <br>
        <!-- <div class="m">
            <h2>Mobile No:-</h2>
            <input type="text" placeholder="Enter Your Mobile No:-">
        </div>
        <br> -->
        <div class="p">
            <h2>Password:-</h2>
            <input type="password" name="password" placeholder="Enter Your Password:-">
        </div>
    </div>

    <div class="ss">
        <div class="su">
            <button type="submit" name="login">
                Submit
            </button>

            
            <!-- <p>Don't have an account? <a href="signup.php">Sign up here</a></p> -->
             <p>Don't have an Account?
             <!-- <button name="signup"> -->
                <a href="signup.php">Signup</a>
            <!-- </button> -->
             </p>
            
        </div>
    </div>
    </form>
</body>
</html>

