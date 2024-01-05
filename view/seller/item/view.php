<?php
  require_once "../../../utils/EncryptService.php";
  require_once "../../../db/dbConnection.php";
  require_once "../../../middleware/RoleMiddleware.php"; 
  require_once "../../../middleware/AuthMiddleware.php";
  require_once "../../../model/Item.php";
  RoleMiddleware::getInstance()->checkRole('seller');

  $result = item::getSellerItem();

  require_once "../../utils/tokenService.php";
  if(getToken() !== $_POST['token']){
    $_SESSION['error'] = "Token invalid";
    header("Location: ../../registerSeller.php");
    die();
  }
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
      <a href="../home.php">Back to Store</a>
    </div>
    <h1>WELCOME SELLER</h1> 
      <a href="./insert.php">
        <button>add item to sell</button>
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
                    
                          
                          echo "<img src= ../../" . $item["item_photo"]
                          . " style=max-width:150px>";
                        
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
                  <!-- <form method="POST">
                    <button type="submit">Update</button>
                  </form> -->
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
  </body>
</html>