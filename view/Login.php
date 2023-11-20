<?php
    session_start();
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
        <form action="../controller/Validation.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
