<?php

    require "../connect.php";
    require "../db/DBConnection.php";
    require "../utils/EncryptService.php";
    abstract class User{
        
        protected int $user_id;
        protected string $user_email;
        protected string $user_password;
        protected string $user_type;
        private $conn = Connect::getInstance();
        protected $db = $this->conn->getDBConnection();
        public function __construct($user_email, $user_password, $user_type){
            $this->user_email = $user_email;
            $this->user_password = $user_password;
            $this->user_type = $user_type;
        }

        public abstract function insert();

        public static function  logout(){
            session_start();
            header("Location: ../index.php");
            session_destroy();
        }

        public static function getUser($user_email){
            
            $query = "SELECT * FROM users WHERE user_email=?";
            $statement = self::$db->prepare($query);
            $statement->bind_param("s", $user_email); 
            $statement->execute();
            $result = $statement->get_result();
            
            if($result->num_rows !=1) {
                $_SESSION['error'] = "Error fetching user";
                return false;
            }
            
            $user = $result->fetch_assoc();
            $statement->close();
            return $user;
            
    }
    
}

?>