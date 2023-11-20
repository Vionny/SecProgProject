<?php
    // require "../db/DBConnection.php";
    session_start();
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../controller/AuthController.php" 
    method="post">
    <h1>WELCOME SELLER</h1>
    email :
    <br>
    <input type="email" name="customer_email"><br>
    password :
    <br>
    <input type="password" name="customer_password"><br>

    first name :
    <br>
    <input type="text" name="customer_first_name"><br>

    last name :
    <br>
    <input type="text" name="customer_last_name"><br>
      
    Date Of Birth
    <br>
    <input type="date" name="customer_DOB"><br>
    <br>
    
    <input type="submit" name="submit" value="register">
    </form>
    
</body>
</html>
