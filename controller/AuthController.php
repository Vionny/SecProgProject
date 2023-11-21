<?php
  require "../db/dbConnection.php";
  require "../model/user.php";
  require "../model/customer.php";
  require "../model/seller.php";
  require "../utils/encryptService.php";

  session_start();
  class AuthController {

    private static $instance;
    private $conn;
    protected $db;
    private function __construct() {
      $this->conn = Connect::getInstance();
      $this->db = $this->conn->getDBConnection();
    }
    
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new AuthController();
        }
        return self::$instance;
    }

    public static function isAuth(){
      $token = $_SESSION['token'];
      if(empty($token)) return false;
      else{
          $token = EncryptService::decryptData($_SESSION);
          $query = "SELECT * FROM users WHERE user_token= ?";
          $statement = self::$db->prepare($query);
          $statement->bind_param("s", $token);
          $statement->execute();
          $result = $statement->get_result();
          if($result->num_rows !=1) {
              $_SESSION['error'] = "Error fetching user";
              return false;
          }
          return true;
      }
  }

    public function registerAsCustomer($user_email, $user_password, $customer_first_name, $customer_last_name, $customer_dob){

      $dob = new DateTime($customer_dob);
      $now = new DateTime();
      if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error']="Please input a valid email";
        return false;
      }else if(strlen($user_password)<8){
        $_SESSION["error"]= "Password must be more 8 or more letters long";
        return false;
      }else if(strlen($customer_first_name)==0){
        $_SESSION["error"]= "Please input the customer first name";
        return false;
      }else if(strlen($customer_last_name)==0){
        $_SESSION["error"]= "Please input the customer last name";
        return false;
      }else if(strlen($customer_last_name)>16){
        $_SESSION["error"]= "Customer last name is to long";
        return false;
      }else if(strlen($customer_first_name)>16){
        $_SESSION["error"]= "Customer first name is to long";
        return false;
      }else if($dob < $now){
        $_SESSION["error"]="Please input a valid birth date";
        return false;
      }else{
        $encrypted_password = EncryptService::hashPassword($user_password);
        $toInsert = new Customer($user_email,$encrypted_password,'customer',$customer_first_name,$customer_last_name,$customer_dob,0);
        $err = $toInsert->insert();

        return $err;
      }

    }

    public function registerSeller($user_email, $user_password, $seller_name, $seller_address, $seller_money){
      if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error']="Please input a valid email";
        return false;
      }else if(strlen($user_password)<8){
        $_SESSION["error"]= "Password must be 8 or more letters long";
        return false;
      }else if(strlen($seller_name)<8){
        $_SESSION["error"] = "Seller Name must be more than 8 ";
      }else if(strlen($$seller_address)<15){
        $_SESSION["error"] = "Seller address must be more than 15 ";
      }else{
        $encrypted_password = EncryptService::hashPassword($user_password);
        $toInsert = new Seller($user_email,$encrypted_password,'seller',$seller_name,$seller_address,$seller_money);
        $err = $toInsert->insert();
        return $err;
      }
    }

    public function loginUser($user_email,$user_password){
      
      if(empty($user_email)){
        $_SESSION["error"]= "Email must be filled";
      }else if(empty($user_password)){
        $_SESSION["error"]= "Password must be filled";
      }else if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error']="Please input a valid email";
        return false;
      }else{
        $userObj = new User();
        $user = $userObj->getUser($user_email);
        if(!$user){
          return false;
        }
        $isUser = EncryptService::checkPassword($user_password,$user['user_password']);
        if($isUser) return true;
        else return false;
      }
    }

  }
?>