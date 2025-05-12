<?php
$host = 'localhost';
$user = 'root'; // Your database username
$pass = ''; // Your database password
$db = 'register'; // Your database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
