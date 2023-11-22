<?php
  require_once "../model/Item.php";
  require_once "../db/dbConnection.php";
  session_start();
  $item_id = $_POST['item_id'];

  
  if(!isset($_SESSION['token'])){
    header("Location: ../view/login.php");
  }
  Item::deleteSellerItem($item_id);
  header("Location: ../view/seller/item/view.php")
?>