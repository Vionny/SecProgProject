<?php
  require_once "../../middleware/RoleMiddleware.php";
  RoleMiddleware::getInstance()->checkRole('customer');
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
    <div>
      <a href="">Item</a>
    </div>
    <div>
      <a href="">Transaction</a>
    </div>
    <div>
      <a href="">Cart</a>
    </div>
    <div>
      <a href="../../actions/doLogout.php">Logout</a>
    </div>
  </div>
</body>
</html>