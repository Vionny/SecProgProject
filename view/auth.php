<?php
    session_start();
    require_once "../db/dbConnection.php";
    require_once "../middleware/AuthMiddleware.php";
    AuthMiddleware::getInstance()->loggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h1>Welcome to our Website!</h1>
    <a href="login.php">Login</a>
    <a href="registerCustomer.php">Register for Customer</a>
    <a href="registerCustomer.php">Register for Seller</a>
</body>
</html>
