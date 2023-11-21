<?php
    session_start();
    require "../utils/tokenService.php";
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
        <input type="hidden" name="token" value=<?=generateToken();?> />
        <h2>Login</h2>
        <?php
            if(isset($_SESSION["error"])) {
                echo "<p>". $_SESSION["error"] ."</p>";
                unset($_SESSION["error"]);
            }
        ?>
        <form action="../action/doLogin.php" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

        <form action="../controller/AuthController.php" method="post">
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
