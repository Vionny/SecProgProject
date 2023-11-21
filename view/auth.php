<?php
    session_start();
    require_once "../middleware/AuthMiddleware.php";
    AuthMiddleware::getInstance()->loggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web</title>
</head>
<body>
    <h1>Saya Ngantuk</h1>
    <a href="login.php">login</a>
    <br>
    <a href="registerCustomer.php">register for customer</a>
    <br>
    <a href="registerCustomer.php">register for seller</a>
</body>
</html>
