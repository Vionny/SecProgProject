<?php
    require_once "../utils/tokenService.php";
    session_start();
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
    <form action="../actions/doRegisterSeller.php" method="post">
        <input type="hidden" name="token" value=<?=generateToken();?> />
        <h1>WELCOME SELLER</h1>
        email :
        <br>
        <input type="email" name="seller_email"><br>
        password :
        <br>
        <input type="password" name="seller_password"><br>

        name :
        <br>
        <input type="text" name="seller_name"><br>
        address :
        <br>
        <input type="text" name="seller_address"><br>
        <br>

        <input type="submit" name="submit" value="register">
    </form>
    
</body>
</html>
