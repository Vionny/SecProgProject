<?php

require_once "../controller/AuthController.php";
require_once "../utils/tokenService.php";
require_once "../model/Item.php";

$item_name = $_POST['item_name'];
$item_description = $_POST['item_description'];
$item_price = $_POST['item_price'];
$item_stock = $_POST['item_stock'];
$item_file = $_FILES['item_file'];

$isInserted = $s->registerItem(
    $item_name, $item_description, $item_price, $item_stock
);

if($isInserted){
  header("Location: ../view/sellerAddItem.php");
  return;
}else{
  header("Location: ../view/sellerAddItem.php");
  return;
}

?>