<?php
 

  class RoleMiddleware{
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

    public function checkRole($accessTo){
      session_start();
      if(isset($_SESSION['token'])){
        $token = $_SESSION['token'];
        $user = AuthMiddleware::getInstance()->checkAuth();
        $query = "SELECT * FROM users WHERE SUBSTR(user_token,17)= ? AND user_type = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ss", $token,$user['user_type']);
        $statement->execute();
        $result = $statement->get_result();
        // var_dump($_SESSION['token']);
        // die();
        $userType = $result->fetch_assoc()['user_type'];
        if($result->num_rows <1) {
          unset($_SESSION['token']);
          header("Location: ../../view/login.php");
        }else if($userType === 'customer' && $accessTo === 'seller'){
          header("Location: ../../view/customer/home.php");
        }else if($userType === 'seller' && $accessTo === 'customer'){
          header("Location: ../../view/seller/home.php");
        }
      }else{
        header("Location: ../../view/login.php");
      }
    }

  }

?>