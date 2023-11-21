<?php
  session_start();
  require_once "../middleware/AuthMiddleware.php";
  AuthMiddleware::getInstance()->isAuth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div>
    <a href="../actions/doLogout.php">Logout</a>
  </div>
</body>
</html>