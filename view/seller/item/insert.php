<?php
  // session_start();

  require_once "../../../db/dbConnection.php";
  require_once "../../../utils/tokenService.php";
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

    <?php
        if(isset($_SESSION["error"])) {
            echo "<p>". $_SESSION["error"] ."</p>";
            unset($_SESSION["error"]);
        }
    ?>

    <form action="../../../actions/doInsertItem.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="token" value="<?= generateToken();?>">
    item name :
    
    <input type="text"  name="item_name" required>

    <br><br>
    item description :
    
    <input type="text"  name="item_description" required>

    <br><br>
    item price :
    <!-- <br> -->
    <input type="text"  name="item_price" required>

    <br><br>
    item stock :
    
    <input type="number"  name="item_stock" required>


    <br><br>
    input picture of the item :
    <br>
    <input type="file" name="item_file" id="item_file" accept=".jpg, .jpeg, .png, .gif" required>

    <br><br>
    <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>


