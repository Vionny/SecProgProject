<?php
  require_once "../../../utils/EncryptService.php";
  require_once "../../../db/dbConnection.php";
  require_once "../../../middleware/RoleMiddleware.php"; 
  require_once "../../../middleware/AuthMiddleware.php";
  require_once "../../../model/Item.php";
  RoleMiddleware::getInstance()->checkRole('seller');

  $result = item::getSellerItem();
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
    <a href="">
        <button>Choose game to sell item</button>
    </a>
    <br><br><br>
    
      <?php
        while($item = $result->fetch_assoc()){
          ?>
          <div style="display:flex;flex-direction:row">
            <div>
              <div style="display:flex;flex-direction: column;">
              <hr>
                <?php
                  if(!empty($item['item_photo'])){
                    ?>
                      <img src="<?= "../../../".$item['item_photo']?>" style="max-width:150px">
                    <?php
                  }
                ?>
                
                <div>
                  <label>Item name : <?= htmlspecialchars($item['item_name'])?></label>
                </div>
                <div>
                  <label>Item description : <?= htmlspecialchars($item['item_description'])?></label>
                </div>
                <div>
                  <label>Item Price : Rp. <?= htmlspecialchars($item['item_price'])?></label>
                </div>
                <div>
                  <label>Item Stock : <?= htmlspecialchars($item['item_stock'])?></label>
                </div>
              </div>
              </div>
              <div style="height:auto;align-items: center;">
                <form method="POST">
                  <button type="submit">Update</button>
                </form>
                <form action="../../../actions/doDeleteItem.php" method="POST">
                  <input type="hidden"name="item_id" value="<?=$item['item_id']?>">
                  <button type="submit">Delete</button>
                </form>
              </div>
              
            </div>
          <hr>
          <?php
        }
      ?>
  </a>
  <a href="./insert.php">Insert Item</a>
</body>
</html>