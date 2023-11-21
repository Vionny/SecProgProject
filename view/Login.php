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
    <title>Web - Login</title>
</head>
<body>
    <div class="login-container">
        
        <h2>Login</h2>
        <?php
            if(isset($_SESSION["error"])) {
                echo "<p>". $_SESSION["error"] ."</p>";
                unset($_SESSION["error"]);
            }
        ?>
        <form action="../actions/doLogin.php" method="post">
        <input type="hidden" name="token" value=<?=generateToken();?> />
            <label for="email">Email:</label>
            <br>
            <input type="email" id="email" name="email" required>
                <br>
            <label for="password">Password:</label>
            <br>
            <input type="password" id="password" name="password" required>
                <br><br>
            <button type="submit">Login</button>
        </form>
    </div>

    <a href="registercustomer.php">register for customer</a>
                <br>
    <a href="registerseller.php">register for seller</a>

   

    

</body>
</html>
