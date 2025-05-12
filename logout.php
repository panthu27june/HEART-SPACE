<?php
session_start();
session_unset();
session_destroy();
header("Location: index.html");
exit();
?>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button>
    <a href="logout.php">Logout</a>

    </button>
</body>
</html> -->