<?php
    session_start();
    require_once "../utils/tokenService.php";
    require_once "../middleware/AuthMiddleware.php";
    AuthMiddleware::getInstance()->loggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_SESSION["error"])) {
            echo "<p>". $_SESSION["error"] ."</p>";
            unset($_SESSION["error"]);
        }
    ?>
    <form action="../actions/doRegisterCustomer.php" method="post">
        <input type="hidden" name="token" value=<?=generateToken();?> />
        <h1>WELCOME CUSTOMER</h1>
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
