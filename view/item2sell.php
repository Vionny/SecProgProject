<?php
    // require "../utils/tokenService.php";
    // require "../controller/AuthController.php";
    // session_start();
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>

    <form action="../actions/doSellItem.php" method="POST">
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


