<?php
  require_once "../../../utils/EncryptService.php";
  require_once "../../../db/dbConnection.php";
  require_once "../../../middleware/RoleMiddleware.php"; 
  require_once "../../../middleware/AuthMiddleware.php";
  
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
<h1>WELCOME SELLER</h1> 
<h1>This is item view</h1>
  <?php


    $query = "select * from items";
    
    $conn = new mysqli(
      'localhost','root','','secprogdb');
    $result = mysqli_query($conn, $query);
      foreach ($result as $row) {
        
          echo 'item name : '. $row['item_name'] ;
        echo "<br>";
      }
  ?>
  
  
    <a href="./insert.php">
        <button>Choose game to sell item</button>
    </a>
    <br><br><br>
  <a href="./insert.php">Insert Item</a>
</body>
</html>