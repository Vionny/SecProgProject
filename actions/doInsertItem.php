<?php

require_once "../controller/AuthController.php";
require_once "../utils/tokenService.php";
require_once "../model/Item.php";
require_once "../controller/ItemController.php";

$item_name = $_POST['item_name'];
$item_description = $_POST['item_description'];
$item_price = $_POST['item_price'];
$item_stock = $_POST['item_stock'];
$item_file = $_FILES['item_file'];


$target_directory = "./../storage/";



$new_file_name = uniqid() . "_" . $item_file["name"];


$file_path = $new_file_name;

// var_dump($item_file['name']);

// if (move_uploaded_file($item_file['tmp_name'], $target_directory . $new_file_name)) {
//   echo "Upload Success!";
// }
// else {
//   echo "Upload Failed.";
// }

if ($item_file['size'] > 20 * 1000 * 1000) {
  echo "File is too big!";
  $_SESSION['error_message'] = "File is too big!";
}

$isInserted = ItemController::getInstance()->registerItem(
    $item_name, $item_description, $item_price, 
    $item_stock,$file_path
);

if($isInserted){
  header("Location: ../view/seller/item/view.php");
  return;
}else{
  header("Location: ../view/seller/item/view.php");
  return;
}

?>