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
  <!-- //TODO : list itemnya semua disini -->
  This is item view
  <h1>WELCOME SELLER</h1> 
    <a href="item2sell.php">
        <button>Choose game to sell item</button>
    </a>
    <br><br><br>
    <a href="item2list.php">
    <button>Item list</button>
  </a>
  <a href="./insert.php">Insert Item</a>
</body>
</html>