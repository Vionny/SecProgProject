<?php

require_once "../controller/AuthController.php";
require_once "../utils/tokenService.php";
require_once "../model/Item.php";
require_once "../controller/ItemController.php";

$item_name = htmlspecialchars($_POST['item_name']);
$item_description = htmlspecialchars($_POST['item_description']);
$item_price = htmlspecialchars($_POST['item_price']);
$item_stock = htmlspecialchars($_POST['item_stock']);
$item_file = htmlspecialchars($_FILES['item_file']);

$isInserted = ItemController::getInstance()->registerItem($item_name, $item_description, $item_price, $item_stock,$item_file);

if($isInserted){
  header("Location: ../view/seller/item/view.php");
  return;
}else{
  header("Location: ../view/seller/item/insert.php");
  return;
}

?>