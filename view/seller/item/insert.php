<?php
  require_once "../../middleware/RoleMiddleware.php";
  RoleMiddleware::getInstance()->checkRole('seller');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="../actions/insertItem.php" method="post">
    <input type="hidden" name="token" value=<?=$_SESSION['token'];?> />

  </form>
</body>
</html>