<?php
  require_once "../utils/EncryptService.php";
  require_once "../db/dbConnection.php";
  class AuthMiddleware{
    
    private static $instance;
    protected $conn;
    protected $db;

    public function __construct(){
      $this->conn = Connect::getInstance();
      $this->db = $this->conn->getDBConnection();
    }
    public static function getInstance(){
      if(!self::$instance) self::$instance = new self();
      return self::$instance;
    }

    private function checkAuth(){
      $token = $_SESSION['token'];
      $query = "SELECT * FROM users WHERE SUBSTR(user_token,17)= ?";
      $statement = $this->db->prepare($query);
      $statement->bind_param("s", $token);
      $statement->execute();
      $result = $statement->get_result();
      // var_dump($_SESSION['token']);
      // die();
      if($result->num_rows <1) {
          $_SESSION['error'] = "Error fetching user";
          header("Location: ../view/login.php");
      }
      return true;
    }

    public function isAuth(){
      
      if(!isset($_SESSION['token'])){
        header('Location: ../view/login.php');
      }
      else{
          return $this->checkAuth();
      }
    }
    
    public function loggedIn(){
      if(isset($_SESSION['token'])&&$this->checkAuth()){
        header('Location: ../view/home.php');
      }
    }
  }
  

?>