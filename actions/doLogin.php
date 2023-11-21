<?php
  require_once "../controller/AuthController.php";
  require_once "../utils/tokenService.php";

  $auth = AuthController::getInstance();

  if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../view/login.php");
    die();
  }
  if(getToken() !== $_POST['token']){
    $_SESSION['error'] = "Token invalid";
    header("Location: ../view/login.php");
    die();
  }
  
  $user_email = $_POST['email'];
  $user_password = $_POST['password'];

  $isUser = $auth->loginUser($user_email, $user_password);
  
  if($isUser){
    header('Location: ../view/home.php');
  }else{
    header("Location: ../view/login.php");
  }



?> 