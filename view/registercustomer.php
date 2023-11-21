<?php
    require "db/DBConnection.php";
    require "utils/EncryptService.php";
    require "controller/AuthController.php";
    
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
    <form action="registercustomer.php" 
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
    <input type="date" name="customer_dob"><br>
    <br>
    
    <input type="submit" name="submit" value="register">
    </form>
    
</body>
</html>


<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $customer_validation = new AuthController();
    $customer_validation->registerAsCustomer($_POST['customer_email'],
    $_POST['customer_password'],$_POST['customer_first_name'],$_POST['customer_last_name'],
    $_POST['customer_dob']);

    echo $_SESSION['error'];
//     $seller_validation = AuthController::registerAsCustomer($_POST['customer_email'],
// $_POST['customer_password'],$_POST['customer_first_name'],$_POST['customer_last_name'],
// $_POST['customer_dob']);
}
?>