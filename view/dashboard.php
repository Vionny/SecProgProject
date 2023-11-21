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
    <title>Web - Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= $_SESSION["username"] ?></h1>
    <a href="../controller/Logout.php"><button>Log Out</button></a>
</body>
</html>
