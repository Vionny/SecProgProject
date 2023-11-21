<?php

require "../controller/AuthController.php";
require "../utils/tokenService.php";

$auth = AuthController::getInstance();


$item_name = $_POST['item_name'];
$item_description = $_POST['item_description'];
$item_price = $_POST['item_price'];
$item_stock = $_POST['item_stock'];
$item_file = $_FILES['item_file'];

$isInserted = $auth->registerItem(
    $item_name, $item_description, $item_price, $item_stock
);

if($isInserted){
  header("Location: ../view/sellerAddItem.php");
  return;
}else{
    echo "heloo";
  header("Location: ../view/sellerAddItem.php");
  return;
}

?>