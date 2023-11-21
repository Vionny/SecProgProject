<?php

require "../controller/AuthController.php";
require "../utils/tokenService.php";

$auth = AuthController::getInstance();

if($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../view/registerCustomer.php");
  die();
}
if(getToken() !== $_POST['token']){
  $_SESSION['error'] = "Token invalid";
  header("Location: ../view/registerCustomer.php");
  die();
}

$user_email = $_POST['customer_email'];
$user_password = $_POST['customer_password'];
$customer_first_name = $_POST['customer_first_name'];
$customer_last_name = $_POST['customer_last_name'];
$customer_dob = $_POST['customer_dob'];

$isInserted = $auth->registerAsCustomer($user_email, $user_password, $customer_first_name, $customer_last_name,$customer_dob);

if($isInserted){
  header("Location: ../view/login.php");
  return;
}else{
  header("Location: ../view/registerCustomer.php");
  return;
}

?>