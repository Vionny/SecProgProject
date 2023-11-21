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
  This is item view
  <a href="./insert.php">Insert Item</a>
</body>
</html>