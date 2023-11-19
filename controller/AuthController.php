<?php
  require "../db/DBConnection.php";
  session_start();
  class AuthController {

    private static $instance;
    private function __construct() {}

    private $conn = Connect::getInstance();
    private $db = $this->conn->getDBConnection();
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function registerAsCustomer($user_email, $user_password, $customer_first_name, $customer_last_name, $customer_dob){

      $dob = new DateTime($customer_dob);
      $now = new DateTime();
      if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error']="Please input a valid email";
        return false;
      }else if(!strlen($user_password)<8){
        $_SESSION["error"]= "Password must be more 8 or more letters long";
        return false;
      }else if(strlen($customer_first_name)==0){
        $_SESSION["error"]= "Please input the customer first name";
        return false;
      }else if(strlen($customer_last_name)==0){
        $_SESSION["error"]= "Please input the customer last name";
      }else if(strlen($customer_last_name)>16){
        $_SESSION["error"]= "Customer last name is to long";
      }else if(strlen($customer_first_name)>16){
        $_SESSION["error"]= "Customer first name is to long";
      }else if($dob < $now){
        $_SESSION["error"]="Please input a valid birth date";
      }else{
        $query = "INSERT INTO `users` (`user_email`, `user_password`, `user_type`) VALUES (?,?,'register');";
        $stmt = $this->db->prepare($query);

      }

    }

  }
?>