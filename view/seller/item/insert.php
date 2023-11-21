<?php

  require_once "../../../db/dbConnection.php";
  require_once "../../../middleware/AuthMiddleware.php";
  require_once "../../../middleware/RoleMiddleware.php";

  RoleMiddleware::getInstance()->checkRole('seller');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>

    <form action="../../../actions/doInsertItem.php" method="POST">
    item name :
    
    <input type="text"  name="item_name">

    <br><br>
    item description :
    
    <input type="text"  name="item_description">

    <br><br>
    item price :
    <!-- <br> -->
    <input type="text"  name="item_price">

    <br><br>
    item stock :
    
    <input type="number"  name="item_stock">


    <br><br>
    input picture of the item :
    <br>
    <input type="file"  name="item_file">

    <br><br>
    <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>


