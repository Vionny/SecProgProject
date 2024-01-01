<?php

  require "../controller/AuthController.php";
  require "../utils/tokenService.php";

  $auth = AuthController::getInstance();

  if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../view/registerSeller.php");
    die();
  }
  if(getToken() !== $_POST['token']){
    $_SESSION['error'] = "Token invalid";
    header("Location: ../view/registerSeller.php");
    die();
  }

  $user_email = $_POST['seller_email'];
  $user_password = $_POST['seller_password'];
  $seller_name = $_POST['seller_name'];
  $seller_address = $_POST['seller_address'];
  
  $_SESSION['username'] = $_POST['seller_name'];

  $isInserted = $auth->registerAsSeller($user_email, $user_password, $seller_name, $seller_address);

  if($isInserted){
    header("Location: ../view/login.php");
    return;
  }else{
    header("Location: ../view/registerSeller.php");
    return;
  }

?>