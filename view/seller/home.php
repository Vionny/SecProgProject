<?php
  require_once "../../db/dbConnection.php";
  require_once "../../middleware/AuthMiddleware.php";
  require_once "../../middleware/RoleMiddleware.php";

  RoleMiddleware::getInstance()->checkRole('seller');

  require_once "../../utils/tokenService.php";
  if(getToken() !== $_POST['token']){
    $_SESSION['error'] = "Token invalid";
    header("Location: ../registerSeller.php");
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
    <div>
      <a href="./item/view.php">View Items</a>
    </div>
    <div>
      <a href="./item/insert.php">Add Item</a>
    </div>
    <div>
      
      <a href="./transaction.php">Transaction</a>
    </div>
    <div>
      <a href="../../actions/doLogout.php">Logout</a>
    </div>

  </div>
</body>
</html>