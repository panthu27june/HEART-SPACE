<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($username) && !empty($password)) {
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "SELECT * FROM `signup` WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if ($password == $row['password']) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                echo "Login successful! Redirecting...";
                echo "<script>setTimeout(() => window.location.href='index.php', 2000);</script>";
                exit();
            } else {
                echo "Incorrect password!";
            }
        } else {
            echo "User not found!";
        }
    } else {
        echo "Please enter Username and Password!";
    }
}

// session_start();
// include("connection.php");

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
//     $username = trim($_POST['username']);
//     $password = trim($_POST['password']);

//     if (!empty($username) && !empty($password)) {
//         $query = "SELECT * FROM signup WHERE username = ?";
//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("s", $username);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result && $result->num_rows > 0) {
//             $row = $result->fetch_assoc();

//             // If you stored password using password_hash() in signup
//             if (password_verify($password, $row['password'])) {
//                 $_SESSION['id'] = $row['id'];
//                 $_SESSION['username'] = $row['username'];
//                 header("Location: index.php");
//                 exit();
//             } else {
//                 echo "<script>alert('Incorrect password');</script>";
//             }
//         } else {
//             echo "<script>alert('User not found');</script>";
//         }
//     } else {
//         echo "<script>alert('Please fill all fields');</script>";
//     }
// }





    

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
    <link rel="shortcut icon" type="x-icon" href="https://i.ibb.co/mVLBxmf8/Heart-Space-Logo-White-BG.png">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
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
                Login
            </button>
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            
        </div>
    </div>
    <!-- <p class="error"></*?php echo $error; ?*/></p> -->
    </form>
</body>
</html>

