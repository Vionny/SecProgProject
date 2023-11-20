<?php
    session_start();
    if (!isset($_SESSION["is_login"])) {
        header("Location: view/Login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web</title>
</head>
<body>
    <h1>Asal Aja</h1>
    <h1>Welcome, <?= $_SESSION["username"] ?></h1>

    
   
</body>
</html>
